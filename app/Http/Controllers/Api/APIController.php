<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\OddsJamAPITrait;
use App\Services\OddsJamGameEventCronJobs\OddsJamGameEventCronJob;
use Illuminate\Support\Facades\Storage;

use DateTime;
use DateTimeZone;

class APIController extends Controller
{
    use OddsJamAPITrait;

    public function getGames(Request $request) {

        // $data = OddsJamGameEventCronJob::first();
        // return json_decode($data->game_event_json);

        $file = public_path('game.json');

        $existingData = file_get_contents($file);

        $gamesExists = json_decode($existingData, true);

        return $gamesExists;
    }

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
 
    public function getGameListingOld(Request $request) {

        $input = ['start_date_before' => "2023-10-05T22:00:00-04:00"];

        // Get the current date without the time
        $currentDate = new \DateTime();
        $currentDateString = $currentDate->format('Y-m-d');

        // Extract the time and timezone from the input string
        $timeParts = explode('T', $input['start_date_before'])[1];

        // Combine the current date with the extracted time
        $input['start_date_before'] = $currentDateString . 'T' . $timeParts;


        $gameData = $this->games($input);
        $sportsBook = $this->defaultSporksBook();

        if (!$gameData['status'] || empty($gameData['data'])) {
            return [];
        }

        $games = $gameData['data']['data'];
        $games = array_slice($games, 0, 15); // Take only first 5 games

        $gameArray = [];
        foreach ($games as $game) {
            if (isset($game['home_team_info']) && isset($game['away_team_info'])) {
                $gameArray[] = $this->fetchOddsData($game, $sportsBook);
            }
        }

        \DB::table('oddsjamgameeventcronjobs')->where('id', 1 )->update([
            'game_event_json'   =>    json_encode($gameArray)
        ]);
        
       return $gameArray;
    }

    public function getGameListing(Request $request) {

        $input = $request->all();

        $gameData = $this->games($input);

        $sportsBook = $this->defaultSporksBook();

        if (!$gameData['status'] || empty($gameData['data'])) {
            return [];
        }

        $games = $gameData['data']['data'];
        $games = array_slice($games, 0, 50); // Take only first 50 games (comment says 5, but code is taking 50)

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
}
