<?php

namespace App\Http\Traits;

use App\Services\SportsBooks\SportsBook;
use URL;

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

        \Log::info($response);

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
            \Log::info($url);

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

            \Log::info($url);
           
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
