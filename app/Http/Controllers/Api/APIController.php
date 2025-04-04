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
    * 
    * Major Functions
    *
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


        
        $bet_query = json_decode('{"over":"Over 10.5","over_best_price":410,"under":"Under 10.5","under_best_price":-525,"over_selection_points":"10.50","under_selection_points":"10.50"}');
        $queryA = json_decode('[{"bet_type":"1st Set Total Games","selection_points":"10.50","selection_line":"over","bet_name":"Over 10.5","sportsbook":"Casumo","max_bet_price":410,"selection":""},{"bet_type":"1st Set Total Games","selection_points":"10.50","selection_line":"over","bet_name":"Over 10.5","sportsbook":"partypoker","max_bet_price":320,"selection":""},{"bet_type":"1st Set Total Games","selection_points":"10.50","selection_line":"over","bet_name":"Over 10.5","sportsbook":"10bet","max_bet_price":300,"selection":""},{"bet_type":"1st Set Total Games","selection_points":"8.50","selection_line":"over","bet_name":"Over 8.5","sportsbook":"Pinnacle","max_bet_price":-170,"selection":""}]');
        $queryB = json_decode('[{"bet_type":"1st Set Total Games","selection_points":"8.50","selection_line":"under","bet_name":"Under 8.5","sportsbook":"Pinnacle","max_bet_price":137,"selection":""},{"bet_type":"1st Set Total Games","selection_points":"10.50","selection_line":"under","bet_name":"Under 10.5","sportsbook":"10bet","max_bet_price":-525,"selection":""},{"bet_type":"1st Set Total Games","selection_points":"10.50","selection_line":"under","bet_name":"Under 10.5","sportsbook":"partypoker","max_bet_price":-600,"selection":""}]  ');  

        $resultsA = array_filter($queryA, function ($record) use ($bet_query) {
            if ( $bet_query->over_selection_points && $bet_query->over ) {
                return $record->bet_name == $bet_query->over && $record->selection_points == $bet_query->over_selection_points;
            }
        });

        $resultsB = array_filter($queryB, function ($record) use ($bet_query) {
            if ( $bet_query->under_selection_points && $bet_query->under ) {
                return $record->bet_name == $bet_query->under && $record->selection_points == $bet_query->under_selection_points;
            }
        });

        $query = [
            'resultsA'    =>  array_values($resultsA),
            'resultsB'    =>  array_values($resultsB)
        ];

        return $query;
    }

    public function getGameInfo($id, $type) {

        $game = GamesPerMarket::where('game_id', $id)->where('bet_type', $type)->first();

        $odds = $this->getOddsPerTeam($game);

        $data = [
            'game'  => $game,
            'odds'  => $odds,
            'slug' => [
                'game_id'   =>   str_slug($id),
                'bet_type' =>   str_slug($type)
            ]
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
