<?php

namespace App\Http\Traits;

use App\Services\SportsBooks\SportsBook;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\Games\Game;
use App\Services\GameOdds\GameOdds;
use App\Events\NewOddsReceived;
use App\Services\GamesPerMarkets\GamesPerMarket;
use URL;
use DB;
use DateTime;
use DateTimeZone;

/**
 * Class OddsJamAPITrait
 * @package App\Http\Traits
 * @author Guevara Web Graphics Studio
 */
trait OddsJamAPITrait
{
    public function games($data) {
        $headers = ["Content-Type: application/json"];
        $baseURL = "https://api-external.oddsjam.com/api/v2/games/";

        $queryParams = [
            'include_team_info' => 'true',
            'key' => config('services.oddsjam.key')
        ];

        if (isset($data['start_date_before']) && $data['start_date_before']) {
            $queryParams['start_date_before'] = $data['start_date_before'];
        }

        if (isset($data['start_date_after']) && $data['start_date_after']) {
            $queryParams['start_date_after'] = $data['start_date_after'];
        }


        $url = $baseURL . '?' . http_build_query($queryParams);

        $response = $this->makeAPIRequest($url, $headers);

        return $response =  [
            'data' => $response,
            'message' => 'Successfully processed..',
            'status' => true
        ];
    }

    public function leagues($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );
            
            $sports ='';
            if(!empty($data)) {
                foreach ($data['sports'] as $sport ) {
                    $sports .= '&sport=' . $sport;
                }
            }

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/leagues/?key=" . config('services.oddsjam.key') . $sports );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
            $output = [
                'data' =>   $response['data'],
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function upcomingGameOdds($data) {

        try {

            $curl = curl_init();

            $baseURL = "https://api-external.oddsjam.com/api/v2/game-odds/";

            $queryParams = [
                'key' => config('services.oddsjam.key'),
                'game_id' => $data['game_id'],
                'team_id' => $data['team_id']
            ];
                        
            $sportsbook = $data['sportsbook'];

            // Convert the non-sportsbook parameters to a query string
            $queryString = http_build_query($queryParams);

            // Manually append the sportsbook parameters to the query string
            foreach ($sportsbook as $sportsbook) {
                $queryString .= '&sportsbook=' . urlencode($sportsbook);
            }

            $url = $baseURL . '?' . $queryString;

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));


            $response = curl_exec($curl);

            curl_close($curl);

            $raw_data = json_decode($response,true);

            $output = [
                'data'  =>  $raw_data['data'],
                'message'   => "Successfully retrieved!",
                'status'    => true
            ];

            // dd($output);
            
        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function futureOdds($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/future-odds/?key=" . config('services.oddsjam.key'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function futures($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );
            
            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/futures/?key=" . config('services.oddsjam.key') . "&sport=basketball&league=ncaa");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function bestGrader($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/grader/?key=" . config('services.oddsjam.key') . "&game_id=39804-16218-24-06&market_name=Moneyline&bet_name=Buffalo");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function gameScores($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/scores/?key=" . config('services.oddsjam.key'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function playerResults($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/player-results/?key=" . config('services.oddsjam.key') . "&game_id=33403-31248-2023-39");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function teams($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/injuries/?key=" . config('services.oddsjam.key'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function players($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/players/?key=" . config('services.oddsjam.key') );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function marketCategories($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            $sports ='';
            if(!empty($data)) {
                foreach ($data['sports'] ?? [] as $sport ) {
                    $sports .= '&sport=' . $sport;
                }
            }

            $leagues ='';
            if(!empty($data)) {
                foreach ($data['leagues'] ?? [] as $league ) {
                    $leagues .= '&league=' . $league;
                }
            }

            $baseURL = "https://api-external.oddsjam.com/api/v2/market-categories/";

            $queryParams = [
                'include_team_info' => 'true',
                'key' => config('services.oddsjam.key')
            ];

            // Assuming $leagues is something like "&league=soccer&league=football"
            parse_str(ltrim($leagues, '&'), $leaguesArray);

            // Merge the two arrays
            $queryParams = array_merge($queryParams, $leaguesArray);

            // Using Laravel's http_build_query function
            $url = $baseURL . '?' . http_build_query($queryParams);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function markets($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            $sportsbooks ='';
            if(!empty($data)) {
                foreach ($data['sportsbook'] as $sportsbook ) {
                    $sportsbooks .= '&sportsbook=' . urlencode($sportsbook);
                }
            }

            $baseURL = "https://api-external.oddsjam.com/api/v2/markets/";

            $queryParams = [
                'key' => config('services.oddsjam.key'),
                'game_id'   =>  $data['game_id']
            ];

            if (isset($data['start_date_before']) && $data['start_date_before']) {
                $queryParams['start_date_before'] = $data['start_date_before'];
            }


            // Using Laravel's http_build_query function
            $url = $baseURL . '?' . http_build_query($queryParams) . $sportsbooks;

            curl_setopt($curl, CURLOPT_URL, $url );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);

            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function upcomingOddsPushStreams($data) {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/stream/odds?key=" . config('services.oddsjam.key') . "&sportsbooks=". $data['sports_book']."&game_id=". $data['game_id']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function sportsBook($data)  {

        try {

            $curl = curl_init();

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/sportsbooks?key=" . config('services.oddsjam.key') . "&game_id=" .$data['game_id']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $json = curl_exec($curl);

            if ($json === false) {
                $error = curl_error($curl);
                $output = [
                    'data'  =>  $error,
                    'message'   =>  'Error.. Something went wrong',
                    'status'    => false
                ];
                return $output;

            }

            curl_close($curl);


            $response = json_decode($json, true);
           
            $output = [
                $response,
                'message'   =>  'Successfully processed..',
                'status'    => true
            ];

        } catch ( \Exception $e ) {

            $output = [
                'data'  =>  NULL,
                'message'   => $e->getMessage(),
                'status'    => false
            ];

        }

        return $output;

    }

    public function defaultSporksBook() {
        $query = SportsBook::orderBy('id','ASC')->get();
        $data = [];
        foreach($query ?? [] as $field ) {
            array_push($data, $field->name);
        }
        return $data;
    }
    
    public function getGamesPerMarket($data) {

        $gamesArray = GamesPerMarket::query()
        ->withTrashed()
        ->from('gamespermarkets as gpm')
        ->leftJoin('games as g', 'g.uid', '=', 'gpm.game_id')
        ->leftJoin('gameodds as go', 'go.game_id', '=', 'gpm.game_id')
        ->where('go.is_live', 0)
        ->where('gpm.profit_percentage','>=', 0)
        ->whereNotIn('gpm.selection_line_a', ['Draw','No Goal'])
        ->where('gpm.selection_line_a','!=',"")
        ->where('gpm.selection_line_b','!=',"")
        ->where('gpm.sportsbook_a', '!=' , "")
        ->where('gpm.sportsbook_b', '!=' , "")
        ->where('is_below_one','<', 1)
        ->select(
            'g.uid',
            'g.start_date',
            'g.home_team',
            'g.away_team',
            'gpm.bet_type',
            'g.sport',
            'g.league',
            'gpm.best_odds_a',
            'gpm.best_odds_b',
            'gpm.selection_line_a',
            'gpm.selection_line_b',
            'gpm.profit_percentage',
            'gpm.sportsbook_a',
            'gpm.sportsbook_b'
        )
        ->groupBy(
            'g.uid',
            'g.start_date',
            'g.home_team',
            'g.away_team',
            'gpm.bet_type',
            'g.sport',
            'g.league',
        )
        ->orderBy('gpm.profit_percentage','DESC')
        ->paginate(10);

        return $gamesArray;

    }

    public function createGamesPerMarket($gameId, $marketArray) {

        try {

            $game_id = $gameId;
            $market = $marketArray;
            
            foreach ( $market ?? [] as  $field ) {

                $game = GameOdds::query()
                ->withTrashed()
                ->from('gameodds as go')
                ->leftJoin('games as g', 'g.uid', '=', 'go.game_id')
                ->where('go.game_id', $game_id )
                ->where('go.bet_type', $field['label'] )
                ->select(
                    'g.uid',
                    'g.start_date',
                    'g.home_team',
                    'g.away_team',
                    'go.bet_type',
                    'g.sport',
                    'g.league'
                )
                ->groupBy(
                    'g.uid',
                    'g.start_date',
                    'g.home_team',
                    'g.away_team',
                    'go.bet_type',
                    'g.sport',
                    'g.league'
                )
                ->first();
                

                if ( !empty($game) && $game != "[]" ) {

                    $odds_data = $this->getOdds($game);

                    $checkExists = GamesPerMarket::where('game_id', $game_id)->where('bet_type', $field['label'])->first();

                    if ( !empty($checkExists) ) {

                        $games_per_market_stored = GamesPerMarket::where('game_id', $game_id)->where('bet_type', $field['label'])->update([
                            'best_odds_a'   =>  $odds_data['best_odds_a'],
                            'best_odds_b'   =>  $odds_data['best_odds_b'],
                            'selection_line_a'  =>  $odds_data['selection_line_a'],
                            'selection_line_b'  =>  $odds_data['selection_line_b'],
                            'profit_percentage' =>  $odds_data['profit_percentage'],
                            'sportsbook_a'  =>  $odds_data['sportsbook_a'],
                            'sportsbook_b'  =>  $odds_data['sportsbook_b'],
                            'is_below_one'  =>  $odds_data['is_below_one']  
                        ]);

                    } else {

                        $games_per_market_stored = GamesPerMarket::create([
                            'game_id'   =>  $game_id,
                            'bet_type'  =>  $field['label'],
                            'best_odds_a'   =>  $odds_data['best_odds_a'],
                            'best_odds_b'   =>  $odds_data['best_odds_b'],
                            'selection_line_a'  =>  $odds_data['selection_line_a'],
                            'selection_line_b'  =>  $odds_data['selection_line_b'],
                            'profit_percentage' =>  $odds_data['profit_percentage'],
                            'sportsbook_a'  =>  $odds_data['sportsbook_a'],
                            'sportsbook_b'  =>  $odds_data['sportsbook_b'],
                            'is_below_one'  =>  $odds_data['is_below_one']  
                        ]);

                        \Log::info('Games Per Market Successfully created!! ' . json_encode($games_per_market_stored) ); 

                    }
                    
                    event(new NewOddsReceived($odds_data));


                }

            }
            
            return $market;
        } catch (\Exception $e) {
            return ['data'  =>  null, 'message' => $e->getMessage() ];
        }
    } 

    public function gameIds(){
        $filePath = public_path('game.json');

        // Read the existing content
        $existingData = File::get($filePath);

        // Decode the JSON data to an array
        $gamesExists = json_decode($existingData, true);
    }
    
    private function makeAPIRequest($url, $headers) {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $json = curl_exec($curl);

            if ($json === false) {
                throw new \Exception(curl_error($curl));
            }

            curl_close($curl);
            return json_decode($json, true);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return [
                'data' => NULL,
                'message' => $e->getMessage(),
                'status' => false
            ];
        }
    }  

    public function getOdds($row) {

        $game_id = $row->uid;
        $bet_type = $row->bet_type;
        
        $home_team = $row->home_team;
        $away_team = $row->away_team;

        $best_odds_a = 0.00;
        $best_odds_b = 0.00;

        $selection_line_a = '';
        $selection_line_b = '';

        $sportsbook_a = '';
        $sportsbook_b = '';

        $sports_book = getSportsBook();
        $counter = 0;

        $best_over_odds_query = null;
        $best_under_odds_query = null;
        
        $search_raw_a = "";
        $search_raw_b = "";
        $latest_raw_a = "";
        $latest_raw_b = "";

        $bet_name = null;

        $game = DB::table('gameodds')
        ->select(
            'game_id',
            'bet_type',
            DB::raw("GROUP_CONCAT(DISTINCT(selection) SEPARATOR ',') AS selection"),
            DB::raw("GROUP_CONCAT(DISTINCT(selection_line) SEPARATOR ',') AS selection_line")
        )
        ->where('game_id', $game_id)
        ->where('bet_type', $bet_type)
        ->whereNotIn('type',    ["locked"])
        ->groupByRaw('game_id, bet_type')
        ->first();

        if (strpos($game->selection, 'Draw') !== false || strpos($game->selection, 'No Goal') !== false ) {
            $data = [
                'best_odds_a'   =>  $best_odds_a,
                'best_odds_b'   =>  $best_odds_b,
                'selection_line_a'   =>  $selection_line_a,
                'selection_line_b'   =>  $selection_line_b,
                'profit_percentage' =>  0,
                'sportsbook_a'  =>  $sportsbook_a,
                'sportsbook_b'  =>  $sportsbook_b
            ];
            return $data;

        } else if (strpos($game->selection_line, 'over') !== false || strpos($game->selection_line, 'under') !== false ) {
            $search_raw_a = "go.selection_line = 'over'";
            $search_raw_b = "go.selection_line = 'under'";
            $latest_raw_a = "x.selection_line = 'over'";
            $latest_raw_b = "x.selection_line = 'under'";

        } else if(strpos($game->selection, $home_team ) !== false || strpos($game->selection,  $away_team) !== false ){
            $search_raw_a = "go.selection LIKE '%".$home_team."%'";
            $search_raw_b = "go.selection LIKE '%".$away_team."%'";
            $latest_raw_a = "x.selection LIKE '%".$home_team."%'";
            $latest_raw_b = "x.selection LIKE '%".$away_team."%'";

        } else if (strpos($game->selection, 'yes') !== false || strpos($game->selection, 'no') !== false ) {
            $search_raw_a = "go.selection LIKE '%yes%'";
            $search_raw_b = "go.selection LIKE '%no%'";
            $latest_raw_a = "x.selection LIKE '%yes%'";
            $latest_raw_b = "x.selection LIKE '%no%'";

        } else if (strpos($game->selection, 'odd') !== false || strpos($game->selection, 'even') !== false ) { 
            $search_raw_a = "go.selection LIKE '%odd%'";
            $search_raw_b = "go.selection LIKE '%even%'";
            $latest_raw_a = "x.selection LIKE '%odd%'";
            $latest_raw_b = "x.selection LIKE '%even%'";

        }

        if ($search_raw_a && $search_raw_b ) {

            $best_over_odds_query = DB::table('gameodds as go')
            ->select(
                'go.bet_type', 
                'go.selection_points', 
                'go.selection_line', 
                'go.bet_name', 
                'go.sportsbook',
                DB::raw('MAX(go.bet_price) as max_bet_price')
            )
            ->whereRaw($search_raw_a)
            ->where('go.game_id', $game_id)
            ->where('go.bet_type', $bet_type)
            ->whereNotIn('go.type', ["locked"])
            ->groupBy('go.sportsbook')
            ->get();

            $notInQuery = $best_over_odds_query->sortByDesc('max_bet_price')->first();

            if ($notInQuery !== null) {
                $notInMaxBetPrice = $notInQuery->max_bet_price;
            } else {
                $notInMaxBetPrice = 0;
            }

            $notIn = $best_over_odds_query->where('max_bet_price', $notInMaxBetPrice)->pluck('sportsbook')->unique()->values()->all();


            $best_under_odds_query = DB::table('gameodds as go')
            ->select(
                'go.bet_type', 
                'go.selection_points', 
                'go.selection_line', 
                'go.bet_name', 
                'go.sportsbook',
                DB::raw('MAX(go.bet_price) as max_bet_price')
            )
            ->whereRaw($search_raw_b)
            ->where('go.game_id', $game_id)
            ->where('go.bet_type', $bet_type)
            ->whereNotIn('go.type', ["locked"])
            ->whereNotIn('go.sportsbook', $notIn )
            ->groupBy('go.sportsbook')
            ->get();

            $bet_name = $this->findMatchedBetName($best_over_odds_query, $best_under_odds_query);
        }


        $highest_over = $best_over_odds_query ? $best_over_odds_query->sortByDesc('max_bet_price')->first() : null;
        $highest_under = $best_under_odds_query ? $best_under_odds_query->sortByDesc('max_bet_price')->first() : null;

        if (!empty($best_over_odds_query) && !empty($best_under_odds_query) && !empty($highest_over) && !empty($highest_under)) {

            $highest_over_bet_price_records = collect($best_over_odds_query)->where('max_bet_price', $highest_over->max_bet_price);
            $highest_under_bet_price_records = collect($best_under_odds_query)->where('max_bet_price', $highest_under->max_bet_price);

            $sportsbooks_over_with_highest_bet_price = $highest_over_bet_price_records->pluck('sportsbook')->unique()->values()->all();
            $sportsbooks_under_with_highest_bet_price = $highest_under_bet_price_records->pluck('sportsbook')->unique()->values()->all();

            $best_odds_a = convertAmericanToDecimalOdds($highest_over->max_bet_price) ?? 0.00;
            $best_odds_b = convertAmericanToDecimalOdds($highest_under->max_bet_price) ?? 0.00;

            $sportsbook_a = $this->sports_book_image($sportsbooks_over_with_highest_bet_price, $sports_book);
            $sportsbook_b = $this->sports_book_image($sportsbooks_under_with_highest_bet_price, $sports_book);
            
            $selection_line_a = $bet_name['over'] ?? '';
            $selection_line_b = $bet_name['under'] ?? '';
        }

        $profit_percentage = $this->calculateProfit($best_odds_a, $best_odds_b);

        $data = [
            'best_odds_a'   => $best_odds_a,
            'best_odds_b'   => $best_odds_b,
            'selection_line_a'   => $selection_line_a,
            'selection_line_b'   => $selection_line_b,
            'profit_percentage' => $profit_percentage,
            'sportsbook_a'  => $sportsbook_a,
            'sportsbook_b'  => $sportsbook_b,
            'best_over_odds_query'  => $best_over_odds_query,
            'best_under_odds_query'  => $best_under_odds_query,
            'is_below_one' => ($best_odds_a > 0 && $best_odds_b > 0) ? (1 / $best_odds_a) + (1 / $best_odds_b) : 0
        ];

        return $data;
    }

    public function sports_book_image($arr, $sports_book) {
        $imagesHTML = '';
        
        // Convert Eloquent Collection to array
        $sports_book_array = $sports_book->toArray();
        
        if (count($arr) > 0) {
            foreach ($arr as $name) {
                if ($name != '') {
                    $book = array_filter($sports_book_array, function($item) use ($name) {
                        return $item['name'] === $name;
                    });

                    // Using current() to get the first item from the filtered array.
                    $book = current($book);

                    if ($book) {
                        $imagesHTML .= '<img class="rounded" width="24" src="' . url($book['image_url']) . '" />';
                    }
                }
            }
        }
        return $imagesHTML;
    }

    public function calculateProfit($oddsA, $oddsB) {
        // Convert the input values to float
        $odds1 = floatval($oddsA);
        $odds2 = floatval($oddsB);

        // $odds1 = floatval(1.44);
        // $odds2 = floatval(3.7);
        
        // Check for division by zero
        if ($odds1 == 0 || $odds2 == 0) {
            return 0;
        }

        // Calculate the profit percentage
        $profitPercentage = (1 - (1 / $odds1 + 1 / $odds2)) * 100;

        // Return the result rounded to two decimal places
        return number_format(abs($profitPercentage),2,'.',',');
    }

    public function findMatchedBetName($queryA, $queryB) {
        
        $overCollection = collect($queryA);
        $underCollection = collect($queryB);

        $matchedBetName = '';

        // Extract the selection_points from both collections
        $overPoints = $overCollection->pluck('selection_points');
        $underPoints = $underCollection->pluck('selection_points');

        // Find the intersection of both sets of selection_points
        $matchedPoints = $overPoints->intersect($underPoints);

        // If there are matched points, find the corresponding bet_name for the matched selection_points
        if ($matchedPoints->isNotEmpty()) {
            $matchedPoint = $matchedPoints->first();

            // Assuming bet_name is a direct attribute of your data items
            $matchedOverBetName = $overCollection->where('selection_points', $matchedPoint)->pluck('bet_name')->first();
            $matchedUnderBetName = $underCollection->where('selection_points', $matchedPoint)->pluck('bet_name')->first();

            $matchedBetName = [
                'over' => $matchedOverBetName,
                'under' => $matchedUnderBetName
            ];
        }

        return $matchedBetName;
    }

}
