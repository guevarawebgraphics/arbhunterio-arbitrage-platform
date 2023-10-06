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
                foreach ($data['sports'] as $sport ) {
                    $sports .= '&sport=' . $sport;
                }
            }

            $leagues ='';
            if(!empty($data)) {
                foreach ($data['leagues'] as $league ) {
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
}
