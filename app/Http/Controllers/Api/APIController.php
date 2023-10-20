<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\OddsJamAPITrait;
use App\Services\OddsJamGameEventCronJobs\OddsJamGameEventCronJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use DateTime;
use DateTimeZone;

class APIController extends Controller
{
    use OddsJamAPITrait;


    /*
    * Major Functions
    *
    */

    public function getGamesOld(Request $request) {

        // $data = OddsJamGameEventCronJob::first();
        // return json_decode($data->game_event_json);
        
        try {
            $file = public_path('game.json');

            $existingData = file_get_contents($file);

            $gamesExists = json_decode($existingData, true);

            \Log::info('Success Games: ' . json_encode($gamesExists) );

            return $gamesExists;
        } catch ( \Exception $e ) {
            \Log::info('Error Games: ' . json_encode($e) );
            return [];
        }

    }

    public function getGames(Request $request) {
        // Define the path to the file in the public directory
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
        
        // Paginate the data
        $perPage = $request->input('per_page', 1000000); // Number of items per page
        $currentPage = $request->input('page', $request->page ? $request->page : 1 ); // Current page
        $pagedData = array_slice($games, ($currentPage - 1) * $perPage, $perPage);

        return response()->json([
            'data' => $pagedData,
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total' => count($games),
        ]);
    }

    public function getGameListing(Request $request) {

        $input = $request->all();

        $gameData = $this->games($input);

        $sportsBook = $this->defaultSporksBook();

        if (!$gameData['status'] || empty($gameData['data'])) {
            return [];
        }

        $games = $gameData['data']['data'];
        $games = array_slice($games, 0, 100); // Take only first 50 games (comment says 5, but code is taking 50)

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

        $upcomingGameOddsInput['team_id'] = $game['away_team_info']['id'];

        $awayTeamOdds = $this->groupOddsByMarket($this->upcomingGameOdds($upcomingGameOddsInput));

        $marketName = $this->markets($upcomingGameOddsInput);

        return [
            'game' => $game,
            'home_team_odds' => $homeTeamOdds,
            'away_team_odds' => $awayTeamOdds,
            'markets'   =>  $marketName[0]['data']
        ];
    }

    private function groupOddsByMarket($oddsData) {
        $grouped = [];

        foreach ($oddsData['data'][0]['odds'] ?? [] as $item) {
            $grouped[$item['market_name']][] = $item;
        }
        return $grouped;
    }

    public function oddsPushStream()
    {
        $sportsbooks = '';
        $sports = getSports();

        $league_input = [];
        $league_input['sports'] = $sports;
        $league_api = $this->leagues($league_input);
        $league = '';

        foreach (getSportsBook() ?? [] as $field) {
            $sportsbooks .= '&sportsbooks=' . urlencode($field->name);
        }

        foreach ( $league_api['data'] ?? [] as $field) {
            $league .= '&league=' . urlencode($field);
        }

        $start_date_before = '2023-10-21T13:00:00-04:00';
        $start_date_after = '2023-10-31T13:00:00-04:00';

        $url = 'https://api-external.oddsjam.com/api/v2/stream/odds?market_name=Moneyline&key=' . urlencode(config('services.oddsjam.key')) . $league . '&start_date_before=' . urlencode($start_date_before) . '&start_date_after=' . urlencode($start_date_after) . $sportsbooks;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_WRITEFUNCTION => function ($ch, $str) {
                $data = trim($str);
                if ($data !== "") {
                    echo "<strong>Response:</strong> $data\n" . "<br><br>";
                    ob_flush();  // Use this to flush the output buffer to ensure real-time streaming
                    flush();     // Use this to flush system output buffer
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
