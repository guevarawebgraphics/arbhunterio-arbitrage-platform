<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\OddsJamAPITrait;
use App\Services\OddsJamGameEventCronJobs\OddsJamGameEventCronJob;
use App\Services\Games\Game;
use App\Services\GameOdds\GameOdds;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Jobs\StoreOddsStreamJob;
use Illuminate\Support\Facades\Queue;
use App\Events\NewOddsReceived;
use App\Services\GamesPerMarkets\GamesPerMarket;
use App\Services\SaveFilters\SaveFilter;
use App\Jobs\StoreGamesPerMarketJob;
use App\Jobs\SendRequestFetchOddsJob;

use DateTime;
use DateTimeZone;
use DateInterval;

use DB;

class APIController extends Controller
{
    use OddsJamAPITrait;

    /*
    * Major Functions
    *
    */

    public function getGames(Request $request)
    {
        // Define the path to the file in the public directory
        $games = $this->gamesPerMarkets([]);
        
        // Paginate the data
        $perPage = $request->input('per_page', 15); // Number of items per page
        $currentPage = $request->input('page', 1); // Current page

        // Slice the array data based on the current page and items per page
        $pagedData = array_slice($games, ($currentPage - 1) * $perPage, $perPage);

        // Create our paginator and pass it to the view
        $paginator = new LengthAwarePaginator($pagedData, count($games), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return response()->json($paginator->toArray());
    }

    public function getGameListing(Request $request)
    {

        $input = $request->all();

        $gameData = $this->games($input);

        $sportsBook = $this->defaultSporksBook();

        if (!$gameData['status'] || empty($gameData['data'])) {
            return [];
        }

        $games = $gameData['data']['data'];

        $games = array_slice($games, 0, 1000); 

        $gameArray = [];

        foreach ($games as $game) {

            if (isset($game['home_team_info']) && isset($game['away_team_info'])) {

                if ($game['status'] != "completed") {

                    $gameArray[] = $this->createGames($game, $sportsBook);

                    $job = new SendRequestFetchOddsJob([
                        'game'  =>  $game ?? [],
                        'sportsbook'    =>  $sportsBook ?? []
                    ]);

                    Queue::pushOn('sync_odds', $job);

                }

            }
        }

        return $gameArray;
            
    }

    private function createGames($game, $sportsBook)
    {

        $checkExists = Game::where( 'uid', $game['id'] )->first();

        $input = [
            'game_id' => $game['id'],
            'sportsbook' => $sportsBook
        ];

        $marketName = $this->markets($input);

        if ( !empty(    $checkExists    ) ) {
            Game::where('uid', $game['id'] )->update([
                'start_date'    => $game['start_date'],
                'home_team' => $game['home_team'],
                'away_team' => $game['away_team'],
                'is_live'   => $game['is_live'], 
                'is_popular'    => $game['is_popular'],   
                'tournament'    => $game['tournament'],     
                'status'    => $game['status'],     
                'sport' => $game['sport'],       
                'league'    => $game['league'],    
                'home_team_info'    => json_encode($game['home_team_info']),  
                'away_team_info'    => json_encode($game['away_team_info']),  
                'markets'   => json_encode($marketName[0]['data'])
            ]);
        } else {
            $games_created = Game::create([
                'uid'   =>  $game['id'],
                'start_date'    => $game['start_date'],
                'home_team' => $game['home_team'],
                'away_team' => $game['away_team'],
                'is_live'   => $game['is_live'], 
                'is_popular'    => $game['is_popular'],   
                'tournament'    => $game['tournament'],     
                'status'    => $game['status'],     
                'sport' => $game['sport'],       
                'league'    => $game['league'],    
                'home_team_info'    => json_encode($game['home_team_info']),  
                'away_team_info'    => json_encode($game['away_team_info']),  
                'markets'   => json_encode($marketName[0]['data'])
            ]);
        }

        return $game;
    }

    public function fetchOddsData(Request $request)
    {

        $game = $request->game;

        $sportsBook = $request->sportsbook;
        
        $upcomingGameOddsInput = [
            'game_id' => $game['id'],
            'team_id' => $game['home_team_info']['id'],
            'sportsbook' => $sportsBook
        ];

        $homeTeamOdds = null;

        $awayTeamOdds = null;

        $bet_type = null;

        $homeTeamOdds = $this->groupOddsByMarket($this->upcomingGameOdds($upcomingGameOddsInput));

        $home_store = $this->processTeamOdds($homeTeamOdds, 0, $game);

        $upcomingGameOddsInput['team_id'] = $game['away_team_info']['id'];

        $awayTeamOdds = $this->groupOddsByMarket($this->upcomingGameOdds($upcomingGameOddsInput));

        $away_store = $this->processTeamOdds($awayTeamOdds, 1, $game);

        $marketName = $this->markets($upcomingGameOddsInput);

        $storeGamesPerMarket = $this->createGamesPerMarket($game['id'], $marketName[0]['data']);

        return [
            'game' => $game,
            'home_team_odds' => $homeTeamOdds,
            'away_team_odds' => $awayTeamOdds,
            'markets'   =>  $marketName[0]['data']
        ];

    }

    private function processTeamOdds($teamOdds, $teamType, $game)
    {
        foreach ($teamOdds ?? [] as $market) {
            foreach ($market ?? [] as $value) {
                
                $gameodds = GameOdds::where('uid', $value['id'])->whereNull('deleted_at')->first();

                $input = [
                    'bet_name'          => $value['name'],
                    'bet_points'        => $value['bet_points'],
                    'bet_price'         => $value['price'],
                    'bet_type'          => $value['market_name'],
                    'game_id'           => $game['id'],
                    'is_live'           => $value['is_live'],
                    'is_main'           => $value['is_main'],
                    'league'            => null,
                    'player_id'         => $value['player_id'],
                    'selection'         => $value['selection'],
                    'selection_line'    => $value['selection_line'],
                    'selection_points'  => $value['selection_points'],
                    'sport'             => NULL,
                    'sportsbook'        => $value['sports_book_name'],
                    'timestamp'         => $value['timestamp'],
                    'entry_id'          => NULL,
                    'market'            => $value['market_name'],
                    'team_type'         => $teamType
                ];

                if (!empty($gameodds)) {

                    $updated_odds = GameOdds::where('uid', $value['id'])->update($input);
                    // \Log::info('processTeamOdds ' . json_encode($updated_odds));
                } else {

                    $input['uid'] = $value['id'];
                    $create_odds = GameOdds::create($input);
                    // \Log::info('processTeamOdds ' . json_encode($create_odds));

                }


            }
        }
    }

    private function groupOddsByMarket($oddsData) {
        $grouped = [];

        foreach ($oddsData['data'][0]['odds'] ?? [] as $item) {
            $grouped[$item['market_name']][] = $item;
        }
        return $grouped;
    }

    public function oddsPushStream(Request $request)
    {
        $batchSize = 10;
        $sportsbooks = '';
        $sports = getSports();
        $league_input = [];
        $league_input['sports'] = $sports;
        $league_api = $this->leagues($league_input);
        $games = GamesPerMarket::orderBy('created_at', 'ASC')->get();
        $league = '';
        $game_ids_array = [];

        foreach (getSportsBook() ?? [] as $field) {
            $sportsbooks .= '&sportsbooks=' . urlencode($field->name);
        }

        // foreach ($league_api['data'] ?? [] as $field) {
        //     $league .= '&league=' . urlencode($field);
        // }

        foreach ($games ?? [] as $field) {
            $game_ids_array[] = 'game_id=' . urlencode($field->game_id);
        }

        $current_time = new DateTime('now', new DateTimeZone('America/New_York'));
        $start_date_before = $current_time->format('Y-m-d\TH:i:sP');
        $current_time->add(new DateInterval('P2D')); // Add 2 days (48 hours)
        $start_date_after = $current_time->format('Y-m-d\TH:i:sP');

        $base_url = 'https://api-external.oddsjam.com/api/v2/stream/odds?key=' . urlencode(config('services.oddsjam.key')) . $league . '&start_date_before=' . $start_date_before . '&start_date_after=' . $start_date_after . $sportsbooks;
       
        $batches = array_chunk($game_ids_array, $batchSize);
        
        foreach ($batches as $batch) {
            $url = $base_url . '&' . implode('&', $batch);
            $this->fetchOddsPushStreamData($url);
        }

    }

    private function fetchOddsPushStreamData($url)
    {
        set_time_limit(0);
     
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        // If you're using output buffering
        ob_start();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_WRITEFUNCTION => function ($ch, $str) {
                $data = trim($str);
                
                if ($data !== "") {
                    if (preg_match('/data: (\{.*\})/', $data, $matches)) {

                        $jsonData = $matches[1];

                        $output = $jsonData ?? 'No records..';
                        echo "data: $output\n\n";

                        $job = new StoreOddsStreamJob($jsonData);
                        Queue::pushOn('push_stream_odds', $job);

                        if (ob_get_level() > 0) {
                            ob_flush();
                        }
                        flush();
                    }
                }
                return strlen($str);
            }
        ]);

        curl_exec($curl);
        curl_close($curl);

        // If you started output buffering, end it
        if (ob_get_level() > 0) {
            ob_end_flush();
        }
    }

    /*
    * End of Major Functions
    * 
    */

    public function getLeagues(Request $request) {

        $input = $request->all();
        $response = $this->leagues($input);
        return $response;

    }

    public function getUpcomingGameOdds(Request $request) {

        $input = $request->all();
        $response = $this->upcomingGameOdds($input);
        return $response;
    }

    public function getFutureOdds(Request $request) {

        $input = $request->all();
        $response = $this->futureOdds($input);
        return $response;

    }

    public function getFutures(Request $request) {
        $input = $request->all();
        $response = $this->futures($input);
        return $response;
    }

    public function getBestGrader(Request $request) {

        $input = $request->all();
        $response = $this->bestGrader($input);
        return $response;

    }

    public function getGameScores(Request $request) {
        
        $input = $request->all();
        $response = $this->gameScores($input);
        return $response;
    }

    public function getPlayerResults(Request $request) {

        $input = $request->all();
        $response = $this->playerResults($input);
        return $response;

    }

    public function getTeams(Request $request) {

        $input = $request->all();
        $response = $this->teams($input);
        return $response;


    }

    public function getPlayers(Request $request) {

        $input = $request->all();
        $response = $this->players($input);
        return $response;

    }

    public function getMarketCategories(Request $request) {

        $input = $request->all();
        
        $input['sports'] = [];

        foreach( getSports() ?? [] as $field) {
            array_push( $input['sports'], $field );
        }

        $response = $this->marketCategories($input);
        
        return $response;

    }

    public function getMarkets(Request $request) {

        $input = $request->all();
        $response = $this->markets($input);
        return $response;

    }

    public function getUpcomingOddsPushStreams(Request $request) {
        $input = $request->all();
        $response = $this->upcomingOddsPushStreams($input);
        return $response;
    }

    public function getSportsBook(Request $request) {
        $input = $request->all();
        $response = $this->sportsBook($input);
        return $response;
    }

    public function testApi() {
        
        $game_id = "22677-12806-23-47";
        $bet_type = "Player Tackles";

        
        $search_raw_a = "go.selection_line = 'over'";
        $search_raw_b = "go.selection_line = 'under'";

        $search_raw_x = "x.selection_line = 'over'";
        $search_raw_y = "y.selection_line = 'under'";

        $latest_raw_a = "x.selection_line = 'over'";
        $latest_raw_b = "x.selection_line = 'under'";

        $latestPricesSubqueryA = DB::table('gameodds as x')
            ->select(
                'x.game_id', 
                'x.bet_type', 
                'x.sportsbook', 
                DB::raw('MAX(x.timestamp) as latest_timestamp'),
                DB::raw('(SELECT x.bet_price FROM gameodds WHERE game_id = x.game_id AND bet_type = x.bet_type AND sportsbook = x.sportsbook ORDER BY timestamp DESC LIMIT 1) as max_bet_price')
            )
            ->where('x.is_live', 0)
            ->whereNotIn('x.type', ['locked'])
            ->whereRaw($search_raw_x)
            ->groupBy('x.game_id', 'x.bet_type', 'x.sportsbook');

            $latestPricesSubqueryB = DB::table('gameodds as y')
            ->select(
                'y.game_id', 
                'y.bet_type', 
                'y.sportsbook', 
                DB::raw('MAX(y.timestamp) as latest_timestamp'),
                DB::raw('(SELECT y.bet_price FROM gameodds WHERE game_id = y.game_id AND bet_type = y.bet_type AND sportsbook = y.sportsbook ORDER BY timestamp DESC LIMIT 1) as max_bet_price')
            )
            ->where('y.is_live', 0)
            ->whereNotIn('y.type', ['locked'])
            ->whereRaw($search_raw_y)
            ->groupBy('y.game_id', 'y.bet_type', 'y.sportsbook');
                    
            $best_over_odds_query  =  DB::table('gameodds as go')
                ->joinSub($latestPricesSubqueryA, 'max_bet_prices', function ($join) {
                    $join->on('go.game_id', '=', 'max_bet_prices.game_id')
                        ->on('go.bet_type', '=', 'max_bet_prices.bet_type')
                        ->on('go.sportsbook', '=', 'max_bet_prices.sportsbook');
                })
                ->select(
                    'go.bet_type', 
                    'go.selection_points', 
                    'go.selection_line', 
                    'go.bet_name', 
                    'go.sportsbook',
                    'max_bet_prices.max_bet_price',
                    'go.selection'
                )
            ->whereRaw($search_raw_a)
            ->where('go.game_id', $game_id)
            ->where('go.bet_type', $bet_type)
            ->where('go.is_live', 0)
            ->whereNotIn('go.type', ['locked'])
            ->groupBy('go.sportsbook')
            ->orderBy('max_bet_price','DESC')
            ->get();

            $notInQuery = $best_over_odds_query->sortByDesc('max_bet_price')->first();

            if ($notInQuery !== null) {
                $notInMaxBetPrice = $notInQuery->max_bet_price;
            } else {
                $notInMaxBetPrice = 0;
            }

            $notIn = $best_over_odds_query->where('max_bet_price', $notInMaxBetPrice)->pluck('sportsbook')->unique()->values()->all();

            $highest_over = $best_over_odds_query ? $best_over_odds_query->sortByDesc('max_bet_price')->first() : null;

            $best_under_odds_query  = DB::table('gameodds as go')
                ->joinSub($latestPricesSubqueryB, 'max_bet_prices', function ($join) {
                    $join->on('go.game_id', '=', 'max_bet_prices.game_id')
                        ->on('go.bet_type', '=', 'max_bet_prices.bet_type')
                        ->on('go.sportsbook', '=', 'max_bet_prices.sportsbook');
                })
                ->select(
                    'go.bet_type', 
                    'go.selection_points', 
                    'go.selection_line', 
                    'go.bet_name', 
                    'go.sportsbook',
                    'max_bet_prices.max_bet_price',
                    'go.selection'
                )
            ->whereRaw($search_raw_b)
            ->where('go.game_id', $game_id)
            ->where('go.bet_type', $bet_type)
            ->where('go.is_live', 0)
            ->whereNotIn('go.type', ['locked'])
            ->whereNotIn('go.sportsbook', $notIn )
            ->where('go.selection', $highest_over->selection )
            ->groupBy('go.sportsbook')
            ->orderBy('max_bet_price','DESC')
            ->get();

           

        $highest_under = $best_under_odds_query ? $best_under_odds_query->sortByDesc('max_bet_price')->first() : null;

        $bet_name = $this->findMatchedPoints($best_over_odds_query, $best_under_odds_query, 1);

        $query = [
            'queryA'    =>  [
                'bet_name'  =>  collect($best_over_odds_query)->sortByDesc('selection_points')->first(),
                'bets'  =>  $best_over_odds_query
            ],
            'queryB'    =>  [
                'bet_name'  =>  collect($best_under_odds_query)->sortByDesc('selection_points')->first(),
                'bets'  =>  $best_under_odds_query
            ],
            'bet_name'  =>  $bet_name
        ];

        return $query;
    }

    public function getGameInfo($id, $type) {

        $game = GamesPerMarket::where('game_id', $id)->where('bet_type', $type)->first();

        $odds = $this->getOddsPerTeam($game);

        $data = [
            'game'  => $game,
            'odds'  => $odds
        ];

        return $data;

    }

    public function updateGameHidden($gameId, $betType, $status){
        
        $games_per_market = GamesPerMarket::where('game_id', $gameId)->where('bet_type', $betType)->update([
            'is_hidden' =>  $status
        ]);

        $response = [
            'status'    =>  true,
            'message'   =>  'Successfully hidden!'
        ];

        return $response;
    }

    public function storeFilter( Request $request ) {
        
        $input = [];
        $input['user_id']   =   $request->user_id;
        $input['name']   =   $request->name_filter;
        $input['min_profit']   =   $request->min_profit;
        $input['max_profit']   =   $request->max_profit;
        $input['sportsbook']   =   json_encode($request->sportsbook);
        $input['sports']   =   json_encode($request->sports);
        $input['markets']   =   json_encode($request->market);
        $input['datetime']   =   $request->date_time;
        $input['is_alert']   =   isset($request->is_alert) ? 1 : 0;

        $query = SaveFilter::create($input);

        $response = [
            'status'    =>  true,
            'data'  =>  $query
        ];

        return $response;

    }

    public function indexFilters($user_id) {
        $query = SaveFilter::where('user_id',  $user_id)->orderBy('created_at','DESC')->get();
        return $query;
    }

    public function destroyFilter($id) {
        $query = SaveFilter::where('id',  $id)->delete();
        return $query;
    }

    public function getFilter($id) {
        $query = SaveFilter::find($id);

        $data = [];

        if (!empty($query)) {
            $data = [
                'user_id'   =>  $query->user_id,
                'name'  =>  $query->name,
                'min_profit'    =>  $query->min_profit,
                'max_profit'    =>  $query->max_profit,
                'sportsbook'    =>  json_decode($query->sportsbook),
                'sports'    =>  json_decode($query->sports),
                'markets'   =>  json_decode($query->markets),
                'datetime'  =>  $query->datetime,
                'is_alert'  =>  $query->is_alert
            ];
        }
        return $data;
    }
    
}
