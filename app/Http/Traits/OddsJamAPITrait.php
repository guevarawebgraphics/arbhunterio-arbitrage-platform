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

        $is_live = isset($data['is_live']) ? $data['is_live'] : 0;

        $is_hidden = isset($data['is_hidden']) ? $data['is_hidden'] : 0;
        
        $gamesArray = GamesPerMarket::where('is_live', $is_live )
        ->where('profit_percentage','>=', 0)
        ->whereNotIn('selection_line_a', ['Draw','No Goal'])
        ->where('selection_line_a','!=',"")
        ->where('selection_line_b','!=',"")
        ->where('sportsbook_a', '!=' , "")
        ->where('sportsbook_b', '!=' , "")
        ->where('is_hidden', $is_hidden)
        // ->where('is_below_one','<', 1)
        ->select(
            'game_id as uid',
            'start_date',
            'home_team',
            'away_team',
            'bet_type',
            'sport',
            'league',
            'best_odds_a',
            'best_odds_b',
            'selection_line_a',
            'selection_line_b',
            'profit_percentage',
            'sportsbook_a',
            'sportsbook_b',
            'is_hidden'
        )
        ->groupBy(
            'game_id',
            'start_date',
            'home_team',
            'away_team',
            'bet_type',
            'sport',
            'league',
        )
        ->orderBy('profit_percentage','DESC')
        ->paginate(10);

        return $gamesArray;

    }

    public function getTotalCounts() {
        
        $pre_match_count = GamesPerMarket::where('is_live', 0 )
        ->where('profit_percentage','>=', 0)
        ->whereNotIn('selection_line_a', ['Draw','No Goal'])
        ->where('selection_line_a','!=',"")
        ->where('selection_line_b','!=',"")
        ->where('sportsbook_a', '!=' , "")
        ->where('sportsbook_b', '!=' , "")
        ->where('is_hidden', 0 )
        ->count();

        $live_count = GamesPerMarket::where('is_live', 1 )
        ->where('profit_percentage','>=', 0)
        ->whereNotIn('selection_line_a', ['Draw','No Goal'])
        ->where('selection_line_a','!=',"")
        ->where('selection_line_b','!=',"")
        ->where('sportsbook_a', '!=' , "")
        ->where('sportsbook_b', '!=' , "")
        ->where('is_hidden', 0 )
        ->count();

         $hidden_count = GamesPerMarket::where('is_live', 0 )
        ->where('profit_percentage','>=', 0)
        ->whereNotIn('selection_line_a', ['Draw','No Goal'])
        ->where('selection_line_a','!=',"")
        ->where('selection_line_b','!=',"")
        ->where('sportsbook_a', '!=' , "")
        ->where('sportsbook_b', '!=' , "")
        ->where('is_hidden', 1 )
        ->count();

        $data = [
            'pre_match_count'  =>   $pre_match_count,
            'live_count'    => $live_count,
            'hidden_count' => $hidden_count
        ];

        return $data;
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

                    $game_info = Game::where('uid', $game_id)->first();

                    if ( !empty($checkExists) ) {

                        $games_per_market_stored = GamesPerMarket::where('game_id', $game_id)->where('bet_type', $field['label'])->update([
                            'start_date'   =>  $game_info->start_date,
                            'home_team'   =>   $game_info->home_team,
                            'away_team'   =>   $game_info->away_team,
                            'sport'   =>   $game_info->sport,
                            'league'   =>   $game_info->league,
                            'is_live'   =>   $game_info->is_live,

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
                            'start_date'   =>  $game_info->start_date,
                            'home_team'   =>   $game_info->home_team,
                            'away_team'   =>   $game_info->away_team,
                            'sport'   =>   $game_info->sport,
                            'league'   =>   $game_info->league,
                            'is_live'   =>   $game_info->is_live,

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

    public function gameIds()
    {
        $filePath = public_path('game.json');

        // Read the existing content
        $existingData = File::get($filePath);

        // Decode the JSON data to an array
        $gamesExists = json_decode($existingData, true);
    }
    
    private function makeAPIRequest($url, $headers)
    {
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
            // \Log::error($e->getMessage());
            return [
                'data' => NULL,
                'message' => $e->getMessage(),
                'status' => false
            ];
        }
    }  

    public function getOdds($row)
    {

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
        $search_raw_x = "";
        $search_raw_y = "";
        $latest_raw_a = "";
        $latest_raw_b = "";

        $is_home_or_away = 0;

        $bet_query = null;

        $game = DB::table('gameodds')
        ->select(
            'game_id',
            'bet_type',
            DB::raw("GROUP_CONCAT(DISTINCT(selection) SEPARATOR ',') AS selection"),
            DB::raw("GROUP_CONCAT(DISTINCT(selection_line) SEPARATOR ',') AS selection_line")
        )
        ->where( 'game_id' , $game_id )
        ->where( 'bet_type' , $bet_type )
        ->whereNotIn( 'type' , ["locked"] )
        ->groupByRaw( 'game_id, bet_type' )
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

            $search_raw_x = "x.selection_line = 'over'";
            $search_raw_y = "y.selection_line = 'under'";

            $latest_raw_a = "x.selection_line = 'over'";
            $latest_raw_b = "x.selection_line = 'under'";

            $is_home_or_away = 1;


        } else if(strpos($game->selection, $home_team ) !== false || strpos($game->selection,  $away_team) !== false ) {

            $search_raw_a = "go.selection LIKE '%".$home_team."%'";
            $search_raw_b = "go.selection LIKE '%".$away_team."%'";

            $search_raw_x = "x.selection LIKE '%".$home_team."%'";
            $search_raw_y = "y.selection LIKE '%".$away_team."%'";
            
            $latest_raw_a = "x.selection LIKE '%".$home_team."%'";
            $latest_raw_b = "x.selection LIKE '%".$away_team."%'";

            $is_home_or_away = 2;

        } else if (strpos($game->selection, 'Yes') !== false || strpos($game->selection, 'No') !== false ) {

            $search_raw_a = "go.selection LIKE '%Yes%'";
            $search_raw_b = "go.selection LIKE '%No%'";

            $search_raw_x = "x.selection LIKE '%Yes%'";
            $search_raw_y = "y.selection LIKE '%No%'";

            $latest_raw_a = "x.selection LIKE '%Yes%'";
            $latest_raw_b = "x.selection LIKE '%No%'";

        } else if (strpos($game->selection, 'Odd') !== false || strpos($game->selection, 'Even') !== false ) { 

            $search_raw_a = "go.selection LIKE '%Odd%'";
            $search_raw_b = "go.selection LIKE '%Even%'";

            $search_raw_x = "x.selection LIKE '%Odd%'";
            $search_raw_y = "y.selection LIKE '%Even%'";

            $latest_raw_a = "x.selection LIKE '%Odd%'";
            $latest_raw_b = "x.selection LIKE '%Even%'";

        }

        if ($search_raw_a && $search_raw_b ) {

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
                    'max_bet_prices.max_bet_price'
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
                    'max_bet_prices.max_bet_price'
                )
            ->whereRaw($search_raw_b)
            ->where('go.game_id', $game_id)
            ->where('go.bet_type', $bet_type)
            ->where('go.is_live', 0)
            ->whereNotIn('go.type', ['locked'])
            ->whereNotIn('go.sportsbook', $notIn )
            ->groupBy('go.sportsbook')
            ->orderBy('max_bet_price','DESC')
            ->get();
        }


        $highest_over = $best_over_odds_query ? $best_over_odds_query->sortByDesc('max_bet_price')->first() : null;

        $highest_under = $best_under_odds_query ? $best_under_odds_query->sortByDesc('max_bet_price')->first() : null;

        if (!empty($best_over_odds_query) && !empty($best_under_odds_query) && !empty($highest_over) && !empty($highest_under)) {

            $bet_query = $this->findMatchedPoints($best_over_odds_query, $best_under_odds_query, $is_home_or_away);

            $highest_over_bet_price_records = collect($best_over_odds_query)->where('max_bet_price', $highest_over->max_bet_price);

            $highest_under_bet_price_records = collect($best_under_odds_query)->where('max_bet_price', $highest_under->max_bet_price);

            $sportsbooks_over_with_highest_bet_price = $highest_over_bet_price_records->pluck('sportsbook')->unique()->values()->all();
            $sportsbooks_under_with_highest_bet_price = $highest_under_bet_price_records->pluck('sportsbook')->unique()->values()->all();

            $sportsbook_a = $this->sports_book_image($sportsbooks_over_with_highest_bet_price, $sports_book);
            $sportsbook_b = $this->sports_book_image($sportsbooks_under_with_highest_bet_price, $sports_book);
            

            if ( !empty($highest_over->selection_points) &&  !empty($highest_under->selection_points) ) {
            
                $selection_line_a = $bet_query['over'] ?? '';
                $selection_line_b = $bet_query['under'] ?? '';
                $best_odds_a = $bet_query ? convertAmericanToDecimalOdds($bet_query['over_best_price']) : 0.00;
                $best_odds_b = $bet_query ? convertAmericanToDecimalOdds($bet_query['under_best_price']) : 0.00;
                
            } else {

                $selection_line_a = $highest_over->bet_name ?? '';
                $selection_line_b = $highest_under->bet_name ?? '';

                $best_odds_a = convertAmericanToDecimalOdds($highest_over->max_bet_price) ?? 0.00;
                $best_odds_b = convertAmericanToDecimalOdds($highest_under->max_bet_price) ?? 0.00;

            }
        
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

        \Log::info('GAMEODDS ' . json_encode($data));

        return $data;
    }

    public function sports_book_image($arr, $sports_book)
    {
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

    public function calculateProfit($oddsA, $oddsB)
    {
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

    public function findMatchedPoints($queryA, $queryB , $is_home_or_away)
    {
        $overCollection = collect($queryA);

        $underCollection = collect($queryB);

        $matchedBetName = '';

        if ( in_array($is_home_or_away, [0,1]) ) {

            $overPoints = $overCollection->pluck('selection_points');
            
            $underPoints = $underCollection->pluck('selection_points');

            $matchedPoints = $overPoints->intersect($underPoints);

            if ($matchedPoints->isNotEmpty()) {
                
                $matchedPoint = $matchedPoints->first();

                $matchedOverBestPrice = collect($queryA)->where('selection_points', $matchedPoint)->sortByDesc('max_bet_price')->first(); 
                $matchedUnderBestPrice = collect($queryB)->where('selection_points', $matchedPoint)->sortByDesc('max_bet_price')->first(); 

                $matchedOverBetName =  collect($queryA)->where('selection_points', $matchedPoint)->sortByDesc('max_bet_price')->first(); 
                $matchedUnderBetName = collect($queryB)->where('selection_points', $matchedPoint)->sortByDesc('max_bet_price')->first();

                $matchedBetName = [
                    'over' => $matchedOverBestPrice->bet_name ?? '',
                    'over_best_price'  =>  $matchedOverBestPrice->max_bet_price ?? 0.00,

                    'under' => $matchedUnderBestPrice->bet_name ?? '',
                    'under_best_price'  =>  $matchedUnderBestPrice->max_bet_price ?? 0.00
                ];
            }

        } else if ($is_home_or_away == 2 ) { 
              // First, try to get all negative selection points from overCollection
            $overPoints = $overCollection->pluck('selection_points')->filter(function ($point) {
                return $point < 0;
            })->values();

            // If there are no negative points, get all positive
            if ($overPoints->isEmpty()) {
                $overPoints = $overCollection->pluck('selection_points')->filter(function ($point) {
                    return $point > 0;
                })->values();
            }

            // If overPoints are negative, underPoints must be positive, and vice versa
            if ($overPoints->first() < 0) {

                // Filter for positive points in underPoints
                $underPoints = $underCollection->pluck('selection_points')->filter(function ($point) {
                    return $point > 0;
                })->values();

            } else {

                // Filter for negative points in underPoints
                $underPoints = $underCollection->pluck('selection_points')->filter(function ($point) {
                    return $point < 0;
                })->values();

            }
            
            // Map both collections to their absolute values
            $overPointsAbs = $overPoints->map(function ($point) {
                return abs($point);
            });

            $underPointsAbs = $underPoints->map(function ($point) {
                return abs($point);
            });

            // Intersect based on absolute values
            $matchedPointsAbs = $overPointsAbs->intersect($underPointsAbs);
            
            \Log::info('overPoints ' . json_encode($overPointsAbs) );
            \Log::info('underPoints ' . json_encode($underPointsAbs) );
            \Log::info('matchedPoints' . json_encode($matchedPointsAbs) );


            if ($matchedPointsAbs->isNotEmpty()) {
                $matchedPointAbs = $matchedPointsAbs->first();

                $matchedOverBestPrice = $overCollection->filter(function ($item) use ($matchedPointAbs) {
                    // Assuming $item is an object, not an array
                    return abs($item->selection_points) == $matchedPointAbs;
                })->sortByDesc('max_bet_price')->first();

                $matchedUnderBestPrice = $underCollection->filter(function ($item) use ($matchedPointAbs) {
                    // Assuming $item is an object, not an array
                    return abs($item->selection_points) == $matchedPointAbs;
                })->sortByDesc('max_bet_price')->first();

                $matchedBetName = [
                    'over' => $matchedOverBestPrice->bet_name ?? '',
                    'over_best_price'  =>  $matchedOverBestPrice->max_bet_price ?? 0.00,
                    'under' => $matchedUnderBestPrice->bet_name ?? '',
                    'under_best_price'  =>  $matchedUnderBestPrice->max_bet_price ?? 0.00
                ];
            }

        }
        
        \Log::info('is_home_or_away' . json_encode($is_home_or_away) );
        \Log::info('overCollection' . json_encode($overCollection) );
        \Log::info('underCollection' . json_encode($underCollection) );
        \Log::info('matchedBetName' . json_encode($matchedBetName) );

        return $matchedBetName;

    }


}
