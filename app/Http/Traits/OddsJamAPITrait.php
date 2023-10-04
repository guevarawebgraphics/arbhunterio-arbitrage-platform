<?php

namespace App\Http\Traits;

/**
 * Class OddsJamAPITrait
 * @package App\Http\Traits
 * @author Guevara Web Graphics Studio
 */
trait OddsJamAPITrait
{
    public function games($data) {

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

            // $url =  "https://api-external.oddsjam.com/api/v2/games/?include_team_info=true&key=" . config('services.oddsjam.key') . ( $data['start_date_before'] ? '&start_date_before=' .$data['start_date_before'] : '' )  . $leagues;

            $baseURL = "https://api-external.oddsjam.com/api/v2/games/";

            $queryParams = [
                'include_team_info' => 'true',
                'key' => config('services.oddsjam.key')
            ];

            if (isset($data['start_date_before']) && $data['start_date_before']) {
                $queryParams['start_date_before'] = $data['start_date_before'];
            }

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
                'data'  =>  $response,
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

            $headers = array(
                "Content-Type: application/json"
            );

            curl_setopt($curl, CURLOPT_URL, "https://api-external.oddsjam.com/api/v2/game-odds?key=" . config('services.oddsjam.key') . "&game_id=" . $data['game_id'] . "&team_id=" . $data['team_id']);
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
           
            $output = $response;

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

            $baseURL = "https://api-external.oddsjam.com/api/v2/markets/";

            $queryParams = [
                'include_team_info' => 'true',
                'key' => config('services.oddsjam.key')
            ];

            if (isset($data['start_date_before']) && $data['start_date_before']) {
                $queryParams['start_date_before'] = $data['start_date_before'];
            }

            // Assuming $leagues is something like "&league=soccer&league=football"
            parse_str(ltrim($leagues, '&'), $leaguesArray);

            // Merge the two arrays
            $queryParams = array_merge($queryParams, $leaguesArray);

            // Using Laravel's http_build_query function
            $url = $baseURL . '?' . http_build_query($queryParams);


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
        $data = [
                '10bet',
                '888sport',
                'bet365',
                'BET99',
                'Betano',
                'Betcris',
                'BetDSI',
                'BetNow',
                'BetOnline',
                'BetonUSA',
                'Betsafe',
                'Betsson',
                'BetUS',
                'BetVictor',
                'Betway',
                'BookMaker',
                'bwin',
                'Casumo',
                'ComeOn!',
                'Coolbet',
                'Everygame',
                'Jazz Sports',
                'LeoVegas',
                'Looselines',
                'LowVig',
                'Mise-o-jeu',
                'MyBookie',
                'Nitrogen',
                'partypoker',
                'Pinnacle',
                'PowerPlay',
                'Royal Panda',
                'Sportsbetting.ag',
                'Sports Interaction',
                'Stake',
                'Suprabets',
                'TonyBet',
                'William Hill',
                'Xbet'
            ];

        return $data;
    }
}
