<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\OddsJamAPITrait;
use App\Services\OddsJamGameEventCronJobs\OddsJamGameEventCronJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Jobs\StoreOddsStreamJob;
use Illuminate\Support\Facades\Queue;


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

    public function oddsPushStream(Request $request)
    {
        $sportsbooks = '';
        $sports = getSports();

        $league_input = [];
        $league_input['sports'] = $sports;
        $league_api = $this->leagues($league_input);
        $league = '';

        $game_ids = '';

        foreach (getSportsBook() ?? [] as $field) {
            $sportsbooks .= '&sportsbooks=' . urlencode($field->name);
        }

        foreach ( $league_api['data'] ?? [] as $field) {
            $league .= '&league=' . urlencode($field);
        }

        foreach ( $request->game_ids ?? [] as $field) {
            $game_ids .= '&game_id=' . urlencode($field);
        }

        $start_date_before = '2023-10-21T13:00:00-04:00';

        $start_date_after = '2023-10-31T13:00:00-04:00';
        
        $url = 'https://api-external.oddsjam.com/api/v2/stream/odds?market_name=Moneyline&key=' . urlencode(config('services.oddsjam.key')) . $game_ids . $league . '&start_date_before=' . urlencode($start_date_before) . '&start_date_after=' . urlencode($start_date_after) . $sportsbooks;

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
