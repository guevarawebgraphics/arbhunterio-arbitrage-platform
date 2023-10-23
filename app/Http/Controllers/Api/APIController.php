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

use DateTime;
use DateTimeZone;
use DateInterval;

class APIController extends Controller
{
    use OddsJamAPITrait;

    /*
    * Major Functions
    *
    */

    public function getGames(Request $request) {
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

    public function getGamesTest(Request $request) {
        // Define the path to the file in the public directory
        $games = $this->gamesPerMarketsTest([]);
        
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

    public function getGameListing(Request $request) {

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
                $gameArray[] = $this->fetchOddsData($game, $sportsBook);
            }
        }
        

        // Define the path to the file in the public directory
        $file = public_path('game.json');

        // Read the existing content
        $existingData = file_get_contents($file);

        // Decode the JSON data to an array
        $gamesExists = json_decode($existingData, true);

        // If the file was empty or not a valid JSON, initialize an empty array
        if (!is_array($gamesExists)) {
            $gamesExists = [];
        }

        // Append the new games to the games array only if they don't exist
        foreach ($gameArray as $game) {
            $gameExists = false;

            // Check if game with the same ID already exists in $gamesExists
            foreach ($gamesExists as $existingGame) {
                if ($existingGame['game']['id'] == $game['game']['id']) {
                    $gameExists = true;
                    break;
                }
            }

            // If game doesn't exist, append it
            if (!$gameExists) {
                $gamesExists[] = $game;
            }
        }

        // Convert the updated games array back to JSON
        $jsonData = json_encode($gamesExists, JSON_PRETTY_PRINT);

        // Save the updated JSON data back to the file
        file_put_contents($file, $jsonData);

        return $gameArray;
            
    }

    private function fetchOddsData($game, $sportsBook) {
        $upcomingGameOddsInput = [
            'game_id' => $game['id'],
            'team_id' => $game['home_team_info']['id'],
            'sportsbook' => $sportsBook
        ];

        $homeTeamOdds = $this->groupOddsByMarket($this->upcomingGameOdds($upcomingGameOddsInput));

        $this->processTeamOdds($homeTeamOdds, 0, $game);

        $upcomingGameOddsInput['team_id'] = $game['away_team_info']['id'];

        $awayTeamOdds = $this->groupOddsByMarket($this->upcomingGameOdds($upcomingGameOddsInput));

        $this->processTeamOdds($awayTeamOdds, 1, $game);

        $marketName = $this->markets($upcomingGameOddsInput);

        $checkExists = Game::where('uid', $game['id'])->first();

        if ( !empty($checkExists) ) {

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

            Game::create([
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



        foreach( $homeTeamOdds ?? [] as $market ) {

            foreach ( $market ?? [] as $value ) {


                $gameodds = GameOdds::where('uid', $value['id'])->whereNull('deleted_at')->first();

                event(new NewOddsReceived($value));

                if (!empty($gameodds)) {
                    
                    GameOdds::where('uid', $value['id'])->update([
                        'bet_name'  =>  $value['name'],
                        'bet_points'=>  $value['bet_points'],
                        'bet_price' =>  $value['price'], 
                        'bet_type'  =>  $value['market_name'],
                        'game_id'   =>  $game['id'],
                        'is_live'   =>  $value['is_live'],
                        'is_main'   =>  $value['is_main'],
                        'league'    =>  null,
                        'player_id' =>  $value['player_id'],
                        'selection' =>  $value['selection'],
                        'selection_line'    =>  $value['selection_line'],
                        'selection_points'  =>  $value['selection_points'],
                        'sport' =>  NULL,
                        'sportsbook'    =>  $value['sports_book_name'],
                        'timestamp' =>  $value['timestamp'],
                        'entry_id'  =>  NULL,
                        'market'    =>   $value['market_name'],
                        'team_type'   =>  0
                    ]);

                } else {

                    $input = [
                        'bet_name'  =>  $value['name'],
                        'bet_points'=>  $value['bet_points'],
                        'bet_price' =>  $value['price'], 
                        'bet_type'  =>  $value['market_name'],
                        'game_id'   =>  $game['id'],
                        'is_live'   =>  $value['is_live'],
                        'is_main'   =>  $value['is_main'],
                        'league'    =>  null,
                        'player_id' =>  $value['player_id'],
                        'selection' =>  $value['selection'],
                        'selection_line'    =>  $value['selection_line'],
                        'selection_points'  =>  $value['selection_points'],
                        'sport' =>  NULL,
                        'sportsbook'    =>  $value['sports_book_name'],
                        'timestamp' =>  $value['timestamp'],
                        'entry_id'  =>  NULL,
                        'market'    =>   $value['market_name'],
                        'uid'   =>  $value['id'], 
                        'team_type'   =>  0
                        
                    ];
                    
                    $create_odds = GameOdds::create($input);

                }
                
            }

        }

        foreach( $awayTeamOdds ?? [] as $market ) {

            foreach ( $market ?? [] as $value ) {


                $gameodds = GameOdds::where('uid', $value['id'])->whereNull('deleted_at')->first();

                event(new NewOddsReceived($value));

                if (!empty($gameodds)) {
                    
                    GameOdds::where('uid', $value['id'])->update([
                        'bet_name'  =>  $value['name'],
                        'bet_points'=>  $value['bet_points'],
                        'bet_price' =>  $value['price'], 
                        'bet_type'  =>  $value['market_name'],
                        'game_id'   =>  $game['id'],
                        'is_live'   =>  $value['is_live'],
                        'is_main'   =>  $value['is_main'],
                        'league'    =>  null,
                        'player_id' =>  $value['player_id'],
                        'selection' =>  $value['selection'],
                        'selection_line'    =>  $value['selection_line'],
                        'selection_points'  =>  $value['selection_points'],
                        'sport' =>  NULL,
                        'sportsbook'    =>  $value['sports_book_name'],
                        'timestamp' =>  $value['timestamp'],
                        'entry_id'  =>  NULL,
                        'market'    =>   $value['market_name'],
                        'team_type'   =>  1
                    ]);

                } else {

                    $input = [
                        'bet_name'  =>  $value['name'],
                        'bet_points'=>  $value['bet_points'],
                        'bet_price' =>  $value['price'], 
                        'bet_type'  =>  $value['market_name'],
                        'game_id'   =>  $game['id'],
                        'is_live'   =>  $value['is_live'],
                        'is_main'   =>  $value['is_main'],
                        'league'    =>  null,
                        'player_id' =>  $value['player_id'],
                        'selection' =>  $value['selection'],
                        'selection_line'    =>  $value['selection_line'],
                        'selection_points'  =>  $value['selection_points'],
                        'sport' =>  NULL,
                        'sportsbook'    =>  $value['sports_book_name'],
                        'timestamp' =>  $value['timestamp'],
                        'entry_id'  =>  NULL,
                        'market'    =>   $value['market_name'],
                        'uid'   =>  $value['id'], 
                        'team_type'   =>  1
                        
                    ];
                    
                    $create_odds = GameOdds::create($input);

                }
                
            }

        }

        return [
            'game' => $game,
            'home_team_odds' => $homeTeamOdds,
            'away_team_odds' => $awayTeamOdds,
            'markets'   =>  $marketName[0]['data']
        ];
    }

    private function processTeamOdds($teamOdds, $teamType, $game) {
        foreach ($teamOdds ?? [] as $market) {
            foreach ($market ?? [] as $value) {
                
                $gameodds = GameOdds::where('uid', $value['id'])->whereNull('deleted_at')->first();
                event(new NewOddsReceived($value));

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
                    GameOdds::where('uid', $value['id'])->update($input);
                } else {
                    $input['uid'] = $value['id'];
                    $create_odds = GameOdds::create($input);
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
        $games = Game::orderBy('created_at', 'ASC')->get();
        $league = '';
        $game_ids_array = [];

        foreach (getSportsBook() ?? [] as $field) {
            $sportsbooks .= '&sportsbooks=' . urlencode($field->name);
        }

        // foreach ($league_api['data'] ?? [] as $field) {
        //     $league .= '&league=' . urlencode($field);
        // }

        foreach ($games ?? [] as $field) {
            $game_ids_array[] = 'game_id=' . urlencode($field->uid);
        }

        $current_time = new DateTime('now', new DateTimeZone('America/New_York'));
        $start_date_before = $current_time->format('Y-m-d\TH:i:sP');
        $current_time->add(new DateInterval('P2D')); // Add 2 days (48 hours)
        $start_date_after = $current_time->format('Y-m-d\TH:i:sP');

        $base_url = 'https://api-external.oddsjam.com/api/v2/stream/odds?key=' . urlencode(config('services.oddsjam.key')) . $league . '&start_date_before=' . $start_date_before . '&start_date_after=' . $start_date_after . $sportsbooks;
       
        // Split game IDs into batches and process each batch
        $batches = array_chunk($game_ids_array, $batchSize);

        foreach ($batches as $batch) {
            $url = $base_url . '&' . implode('&', $batch);
            $this->fetchOddsPushStreamData($url);
        }

    }

    private function fetchOddsPushStreamData($url)
    {
        // dd($url);
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
                        $job = new StoreOddsStreamJob($jsonData);
                        Queue::push($job);
                        
                        echo "$jsonData\n" . "<br><br>";
                        ob_flush();  // Use this to flush the output buffer to ensure real-time streaming
                        flush();     // Use this to flush system output buffer
                    }

                }
                return strlen($str);
            }
        ]);

        curl_exec($curl);
        curl_close($curl);
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
}
