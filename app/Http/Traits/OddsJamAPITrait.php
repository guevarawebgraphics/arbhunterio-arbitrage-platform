<?php

namespace App\Http\Traits;

use App\Services\SportsBooks\SportsBook;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\Games\Game;
use App\Services\GameOdds\GameOdds;
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

        // \Log::info($response);

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
            // \Log::info($url);

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

            // \Log::info($url);
           
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

    // JSON Version
    public function gamesPerMarkets($data) {
        $filePath = public_path('game.json');

        // Read the existing content
        $existingData = File::get($filePath);

        // Decode the JSON data to an array
        $gamesExists = json_decode($existingData, true);

        $counter = 0;

        $games = [];

        $sports_book = getSportsBook();

        foreach ( $gamesExists ?? [] as $value ) { 

            foreach ( $value['markets'] ?? [] as $val ) {

                $dateTime = new DateTime($value['game']['start_date']);
                $formattedDate = $dateTime->format('D, M j at g:i A');

                $home_odds = $value['home_team_odds'];
                $away_odds = $value['away_team_odds'];
                $market_name = $val['label'];

                $over_best_odds = 0;
                $under_best_odds = 0;
                $over_selection_line = '';
                $under_selection_line = '';
                $over_sports_books = [];
                $under_sports_books = [];


                // NON - Over and Under Variables
                $home_best_odds = 0;
                $away_best_odds = 0;
                $home_selection_line = '';
                $away_selection_line = '';
                $home_sports_books = [];
                $away_sports_books = [];

                $homeMarketOdds = $home_odds[$market_name] ?? [];
                $awayMarketOdds = $away_odds[$market_name] ?? [];
                $mergedOdds = array_merge($homeMarketOdds, $awayMarketOdds);


                foreach ($mergedOdds as $index => $obj) {
                    if ($obj['selection_line'] === 'over' && $obj['bet_points'] >= $over_best_odds && $obj['is_live'] == false) {
                        if ($obj['bet_points'] > $over_best_odds) {
                            $over_best_odds = $obj['bet_points'];
                            $over_sports_books = [$obj['sports_book_name']];
                        } elseif (!in_array($obj['sports_book_name'], $over_sports_books)) {
                            $over_sports_books[] = $obj['sports_book_name'];
                        }
                    }
                    
                    if ($obj['selection_line'] === 'under' && $obj['bet_points'] >= $under_best_odds && $obj['is_live'] == false) {
                        if ($obj['bet_points'] > $under_best_odds) {
                            $under_best_odds = $obj['bet_points'];
                            $under_sports_books = [$obj['sports_book_name']];
                        } elseif (!in_array($obj['sports_book_name'], $under_sports_books)) {
                            $under_sports_books[] = $obj['sports_book_name'];
                        }
                    }
                }

                $found_matched_over_under = $this->findMatchingBets($mergedOdds, null, 1);
                $over_selection_line = isset($found_matched_over_under['over']['name']) ? $found_matched_over_under['over']['name'] : null;
                $under_selection_line = isset($found_matched_over_under['under']['name']) ? $found_matched_over_under['under']['name'] : null;

                $over_sports_book_images = $this->sports_book_image($over_sports_books, $sports_book);
                $under_sports_book_images = $this->sports_book_image($under_sports_books, $sports_book);


                // Retrieval of Home and Away Odds
                foreach ($home_odds[$market_name] ?? [] as $index => $obj) {
                    if (!isset($obj['selection_line']) || ($obj['selection_line'] != 'over' && $obj['selection_line'] != 'under')) {
                        if ($obj['bet_points'] > $home_best_odds) {
                            $home_best_odds = $obj['bet_points'];
                            $home_sports_books = [$obj['sports_book_name']];
                        } elseif (!in_array($obj['sports_book_name'], $home_sports_books)) {
                            $home_sports_books[] = $obj['sports_book_name'];
                        }
                    }
                }

                foreach ($away_odds[$market_name]  ?? [] as $index => $obj) {
                    if (!isset($obj['selection_line']) || ($obj['selection_line'] != 'over' && $obj['selection_line'] != 'under')) {
                        if ($obj['bet_points'] > $away_best_odds) {
                            $away_best_odds = $obj['bet_points'];
                            $away_sports_books = [$obj['sports_book_name']];
                        } elseif (!in_array($obj['sports_book_name'], $away_sports_books)) {
                            $away_sports_books[] = $obj['sports_book_name'];
                        }
                    }
                }

                $home_away_found_matched_over_under = $this->findMatchingBets($home_odds[$market_name] ?? [] , $away_odds[$market_name]  ?? [] , 2);

                $home_selection_line = isset($home_away_found_matched_over_under['home']['name']) ? $home_away_found_matched_over_under['home']['name'] : null;
                $away_selection_line = isset($home_away_found_matched_over_under['away']['name']) ? $home_away_found_matched_over_under['away']['name'] : null;

                // Sports Book Dynamic Images
                $home_sports_book_images = $this->sports_book_image($home_sports_books, $sports_book);
                $away_sports_book_images = $this->sports_book_image($away_sports_books, $sports_book);


                $is_html = '0';

                // Must be greater than 0 and Over and Under Best Odds must be multiplied by 4 and result must be greater than or equal to 4
                if ($over_best_odds > 0 && $under_best_odds > 0 && (($over_best_odds * $under_best_odds) >= 4) && $over_selection_line && $under_selection_line) {
                    $is_html = '1';
                } elseif ($home_best_odds > 0 && $away_best_odds > 0 && (($home_best_odds * $away_best_odds) >= 4) && $home_selection_line && $away_selection_line) {
                    $is_html = '2';
                } elseif (($home_best_odds * $away_best_odds) >= 4) {
                    $is_html = '3';
                }

                $profit_percentage = ($is_html == '1') 
                ? $this->calculateProfit($over_best_odds, $under_best_odds) 
                : $this->calculateProfit($home_best_odds, $away_best_odds);


                $selection_line_up = ($is_html == 1) 
                                    ? $over_selection_line 
                                        : (($is_html == 2) 
                                            ? $home_selection_line 
                                            : $value['game']['home_team_info']['team_name'] ?? null);

                $selection_line_down =  ($is_html == 1) 
                                        ? $under_selection_line 
                                        : (($is_html == 2) 
                                            ? $away_selection_line 
                                            : $value['game']['away_team_info']['team_name'] ?? null);

                $best_odds_up = $is_html == 1 ? $over_best_odds : $home_best_odds;

                $best_odds_down = $is_html == 1 ? $under_best_odds : $away_best_odds;

                $sports_book_images_up = $is_html == 1 ? $over_sports_book_images : $home_sports_book_images;

                $sports_book_images_down =  $is_html == 1 ? $under_sports_book_images : $away_sports_book_images;

                if ($best_odds_up > 0 && $best_odds_down > 0 && ( $best_odds_up * $best_odds_down >= 0 ) ) {
                    array_push(
                        $games,
                        [
                            'game_id'   =>  $value['game']['id'],
                            'profit_percentage' =>  $profit_percentage,
                            'formattedDate' =>  $formattedDate,
                            'home_team' =>  $value['game']['home_team'],
                            'away_team' =>  $value['game']['away_team'],
                            'sports'    =>  $value['game']['sport'],
                            'league'    =>  $value['game']['league'],
                            'league'    =>  $value['game']['league'],
                            'market'    =>  $val['label'],
                            'selection_line'    =>  [
                                'over' =>  $selection_line_up,
                                'under'   => $selection_line_down,
                            ],
                            'best_odds' =>[
                                'over'  =>  $best_odds_up,
                                'under'  =>  $best_odds_down,
                            ],
                            'sports_book'   =>  [
                                'over'  =>  $sports_book_images_up,
                                'under' =>  $sports_book_images_down
                            ]
                        ]
                    );

                    $counter++;
                }
            }

        }

        return $games;
    }

    // All in one array
    public function gamesPerMarketsV2($data) {
        $perPage = 5;
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $counter = 0;

        $games = [];

        $sports_book = getSportsBook();

        $gamesArray = [];

        while (count($gamesArray) < $perPage) {
            // $gamesExists = Game::whereNull('deleted_at')->orderBy('created_at', 'DESC')->skip(($currentPage - 1) * $perPage)->take($perPage)->get();
            $gamesExists = Game::whereNull('deleted_at')->orderBy('created_at', 'DESC')->get();

            // If no more games, just break
            if (!$gamesExists->count()) {
                break;
            }
                foreach ( $gamesExists ?? [] as $value ) { 

                    foreach ( json_decode($value->markets) ?? [] as $val ) {

                        $dateTime = new DateTime($value->start_date);
                        $formattedDate = $dateTime->format('D, M j at g:i A');

                        $home_odds = GameOdds::where('game_id', $value->uid )->where('bet_type', $val->label)->where('team_type', 0)->orderBy('created_at','DESC')->get();
                        $away_odds = GameOdds::where('game_id', $value->uid )->where('bet_type', $val->label)->where('team_type', 1)->orderBy('created_at','DESC')->get();

                        $market_name = $val->label;

                        $over_best_odds = 0;
                        $under_best_odds = 0;
                        $over_selection_line = '';
                        $under_selection_line = '';
                        $over_sports_books = [];
                        $under_sports_books = [];


                        // NON - Over and Under Variables
                        $home_best_odds = 0;
                        $away_best_odds = 0;
                        $home_selection_line = '';
                        $away_selection_line = '';
                        $home_sports_books = [];
                        $away_sports_books = [];

                        $homeMarketOdds = $home_odds ?? [];
                        $awayMarketOdds = $away_odds ?? [];

                        $mergedOdds = $homeMarketOdds->merge($awayMarketOdds);

                        foreach ($mergedOdds as $index => $obj) {
                            
                            if ($obj->selection_line === 'over' && $obj->bet_points >= $over_best_odds && $obj->is_live == false) {
                                if ($obj->bet_points > $over_best_odds) {
                                    $over_best_odds = $obj->bet_points;
                                    $over_sports_books = [$obj->sportsbook];
                                } elseif (!in_array($obj->sportsbook, $over_sports_books)) {
                                    $over_sports_books[] = $obj->sportsbook;
                                }
                            }
                            
                            if ($obj->selection_line === 'under' && $obj->bet_points >= $under_best_odds && $obj->is_live == false) {
                                if ($obj->bet_points > $under_best_odds) {
                                    $under_best_odds = $obj->bet_points;
                                    $under_sports_books = [$obj->sportsbook];
                                } elseif (!in_array($obj->sportsbook, $under_sports_books)) {
                                    $under_sports_books[] = $obj->sportsbook;
                                }
                            }
                        }

                        $found_matched_over_under = $this->findMatchingBets($mergedOdds->toArray(), null, 1);
                        
                        $over_selection_line = isset($found_matched_over_under['over']['bet_name']) ? $found_matched_over_under['over']['bet_name'] : null;
                        $under_selection_line = isset($found_matched_over_under['under']['bet_name']) ? $found_matched_over_under['under']['bet_name'] : null;
                    

                        $over_sports_book_images = $this->sports_book_image($over_sports_books, $sports_book);
                        $under_sports_book_images = $this->sports_book_image($under_sports_books, $sports_book);

                        foreach ($homeMarketOdds ?? [] as $index => $obj) {
                            if (!isset($obj->selection_line) || ($obj->selection_line != 'over' && $obj->selection_line != 'under')) {
                                if ($obj->bet_points > $home_best_odds) {
                                    $home_best_odds = $obj->bet_points;
                                    $home_sports_books = [$obj->sportsbook];
                                } elseif (!in_array($obj->sportsbook, $home_sports_books)) {
                                    $home_sports_books[] = $obj->sportsbook;
                                }
                            }
                        }

                        foreach ($awayMarketOdds  ?? [] as $index => $obj) {
                            if (!isset($obj->selection_line) || ($obj->selection_line != 'over' && $obj->selection_line != 'under')) {
                                if ($obj->bet_points > $away_best_odds) {
                                    $away_best_odds = $obj->bet_points;
                                    $away_sports_books = [$obj->sportsbook];
                                } elseif (!in_array($obj->sportsbook, $away_sports_books)) {
                                    $away_sports_books[] = $obj->sportsbook;
                                }
                            }
                        }

                        $home_away_found_matched_over_under = $this->findMatchingBets($homeMarketOdds->toArray(), $awayMarketOdds->toArray(), 2);

                        $home_selection_line = isset($home_away_found_matched_over_under['home']['name']) ? $home_away_found_matched_over_under['home']['name'] : null;
                        $away_selection_line = isset($home_away_found_matched_over_under['away']['name']) ? $home_away_found_matched_over_under['away']['name'] : null;

                        // Sports Book Dynamic Images
                        $home_sports_book_images = $this->sports_book_image($home_sports_books, $sports_book);
                        $away_sports_book_images = $this->sports_book_image($away_sports_books, $sports_book);


                        $is_html = '0';

                        // Must be greater than 0 and Over and Under Best Odds must be multiplied by 4 and result must be greater than or equal to 4
                        if ($over_best_odds > 0 && $under_best_odds > 0 && (($over_best_odds * $under_best_odds) >= 4) && $over_selection_line && $under_selection_line) {
                            $is_html = '1';
                        } elseif ($home_best_odds > 0 && $away_best_odds > 0 && (($home_best_odds * $away_best_odds) >= 4) && $home_selection_line && $away_selection_line) {
                            $is_html = '2';
                        } elseif (($home_best_odds * $away_best_odds) >= 4) {
                            $is_html = '3';
                        }

                        $profit_percentage = ($is_html == '1') 
                        ? $this->calculateProfit($over_best_odds, $under_best_odds) 
                        : $this->calculateProfit($home_best_odds, $away_best_odds);


                        $selection_line_up = ($is_html == 1) 
                                            ? $over_selection_line 
                                                : (($is_html == 2) 
                                                    ? $home_selection_line 
                                                    : $value->home_team ?? null);

                        $selection_line_down =  ($is_html == 1) 
                                                ? $under_selection_line 
                                                : (($is_html == 2) 
                                                    ? $away_selection_line 
                                                    : $value->away_team ?? null);

                        $best_odds_up = $is_html == 1 ? $over_best_odds : $home_best_odds;

                        $best_odds_down = $is_html == 1 ? $under_best_odds : $away_best_odds;

                        $sports_book_images_up = $is_html == 1 ? $over_sports_book_images : $home_sports_book_images;

                        $sports_book_images_down =  $is_html == 1 ? $under_sports_book_images : $away_sports_book_images;

                        // if ($best_odds_up > 0 && $best_odds_down > 0 && ( $best_odds_up * $best_odds_down >= 0 ) ) {

                            array_push(
                                $gamesArray,
                                [
                                    'game_id'   =>  $value->uid,
                                    'profit_percentage' =>  $profit_percentage,
                                    'formattedDate' =>  $formattedDate,
                                    'home_team' =>  $value->home_team,
                                    'away_team' =>  $value->away_team,
                                    'sports'    =>  $value->sport,
                                    'league'    =>  $value->league,
                                    'market'    =>  $market_name,
                                    'selection_line'    =>  [
                                        'over' =>  $selection_line_up,
                                        'under'   => $selection_line_down,
                                    ],
                                    'best_odds' =>[
                                        'over'  =>  $best_odds_up,
                                        'under'  =>  $best_odds_down,
                                    ],
                                    'sports_book'   =>  [
                                        'over'  =>  $sports_book_images_up,
                                        'under' =>  $sports_book_images_down
                                    ]
                                ]
                            );

                            // dd($gamesArray);

                            $counter++;

                        // }
                        
                    }

                }

            // If we didn't fill up our results, we'll need to look at the next page on the next iteration
            $currentPage++;
        }

        $totalGames = Game::whereNull('deleted_at')->count(); // Total number of games for the paginator

        usort($gamesArray, function($a, $b) {
            return $b['profit_percentage'] <=> $a['profit_percentage'];
        });

        // $paginator = new LengthAwarePaginator($gamesArray, $totalGames, $perPage);

        return $gamesArray;
    }
    
    // Minimized Query
    public function gamesPerMarketsV3($data) {

        $gamesArray = GameOdds::query()
            ->withTrashed()
            ->from('gameodds as go')
            ->leftJoin('games as g', 'g.uid', '=', 'go.game_id')
            ->where('go.is_live', 0)
            ->where('go.is_main', 0)
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
            ->orderBy('g.start_date','DESC')
            ->paginate(30);

        return $gamesArray;

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

    function findMatchingBets($dataObj1, $dataObj2, $type) {
        
        if ($type == 1) {

            // Convert the object to an array.
            $dataArray = array_values($dataObj1);

            $overs = array_filter($dataArray, function($item) {
                return $item['selection_line'] === "over";
            });

            $unders = array_filter($dataArray, function($item) {
                return $item['selection_line'] === "under";
            });

            $matchingPairs = [];

            foreach ($overs as $over) {
                foreach ($unders as $under) {
                    if (abs($over['selection_points']) === abs($under['selection_points'])) {
                        $matchingPairs[] = ['over' => $over, 'under' => $under];
                    }
                }
            }

            if (count($matchingPairs) === 0) {
                return null;
            }

            $highestSelectionPoint = max(array_map(function($pair) {
                return abs($pair['over']['selection_points']);
            }, $matchingPairs));

            $highestPair = array_filter($matchingPairs, function($pair) use ($highestSelectionPoint) {
                return abs($pair['over']['selection_points']) === $highestSelectionPoint;
            });

            return array_values($highestPair)[0];

        } elseif ($type == 2 && $dataObj1 && $dataObj2) {


            // Convert the object to an array.
            $dataArray1 = array_values($dataObj1);
            $dataArray2 = array_values($dataObj2);

            $homes = array_filter($dataArray1, function($item) {
                return $item['selection_line'] != "over" && $item['selection_line'] != "under";
            });

            $aways = array_filter($dataArray2, function($item) {
                return $item['selection_line'] != "over" && $item['selection_line'] != "under";
            });

            $matchingPairs = [];

            foreach ($homes as $home) {
                $matched = false;


                if ($home['selection_points'] > 0) {
                    foreach ($aways as $away) {
                        
                        if ($home['selection_points'] === -$away['selection_points']) {
                            $matchingPairs[] = ['home' => $home, 'away' => $away];
                            
                            $matched = true;
                            break;
                        }
                    }
                }

                if (!$matched && $home['selection_points'] < 0) {
                    foreach ($aways as $away) {
                        if (-$home['selection_points'] === $away['selection_points']) {
                            $matchingPairs[] = ['home' => $home, 'away' => $away];
                            \Log::info('Inside' . json_encode($matchingPairs));
                            break;
                        }
                    }
                }
            }

            if (count($matchingPairs) === 0) {
                return null;
            }

            $highestSelectionPoint = max(array_map(function($pair) {
                return abs($pair['home']['selection_points']);
            }, $matchingPairs));

            $highestPair = array_filter($matchingPairs, function($pair) use ($highestSelectionPoint) {
                return abs($pair['home']['selection_points']) === $highestSelectionPoint;
            });

            return array_values($highestPair)[0];
        }
    }

    function sports_book_image($arr, $sports_book) {
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

    function calculateProfit($oddsA, $oddsB) {
        // Convert the input values to float
        $odds1 = floatval($oddsA);
        $odds2 = floatval($oddsB);
        
        // Check for division by zero
        if ($odds1 == 0 || $odds2 == 0) {
            return 0;
        }

        // Calculate the profit percentage
        $profitPercentage = (1 - (1 / $odds1 + 1 / $odds2)) * 100;

        // Return the result rounded to two decimal places
        return abs(round($profitPercentage, 2));
    }

}
