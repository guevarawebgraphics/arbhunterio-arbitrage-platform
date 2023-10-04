<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\OddsJamAPITrait;

class APIController extends Controller
{
    use OddsJamAPITrait;

    public function getGames(Request $request) {
        $input = $request->all();
        $response = $this->games($input);
        return $response;
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

    public function getGameListing(Request $request) {
        // $input = $request->all();
        // $input['start_date_before'] = "2024-04-11T16:35:00-05:00";

        // $gameData = $this->games($input);

        // $game_array = [];

        // if ($gameData['status'] && !empty($gameData['data'])) {
        //     $response = $gameData['data'];
        //     $count = 0;

        //     foreach ($response['data'] as $game) {
        //         $count++;

        //             // SportsBook
        //             $sports_book_input = ['game_id' => $game['id']];
        //             $sports_book = $this->sportsBook($sports_book_input);
        //             $sports_book_data = $sports_book[0]['data'];

        //             $home_team = $game['home_team_info'];
        //             $away_team = $game['away_team_info'];

        //         if ( isset($home_team) && isset($away_team) ) {

        //             $upcomingGameOddsInput = [];
        //             $upcomingGameOddsInput['game_id']    =   $game['id'];
        //             $upcomingGameOddsInput['market_name']    =   "Moneyline";
        //             // $upcomingGameOddsInput['is_main']    =   true;
        //             $upcomingGameOddsInput['team_id']    =   $home_team['id'];
        //             // Retrieve odds per team
        //             // Home Team
        //             $upcomingGameOddsHomeTeam = $this->upcomingGameOdds($upcomingGameOddsInput);

        //             // Away Team
        //             $upcomingGameOddsInput['team_id']    =   $away_team['id'];
        //             $upcomingGameOddsAwayTeam = $this->upcomingGameOdds($upcomingGameOddsInput);

        //             array_push($game_array, [
        //                 'game' => $game,
        //                 'sports_book' => $sports_book_data,
        //                 'home_team' =>  $upcomingGameOddsHomeTeam['data'][0]['odds'],
        //                 'away_team' => $upcomingGameOddsAwayTeam['data'][0]['odds']
        //             ]);

        //             dd($game_array);

        //         }
                    
        //     }
        // }


        $sports = [
            'football','basketball','baseball','mma','boxing','hockey','soccer','tennis','golf','motorsports','esports','wrestling','aussie-rules','rugby'
        ];

        $input = [];
        $input['start_date_before'] = "2024-04-11T16:35:00-05:00";
        $input['sports']    =   $sports;

        $league_raw = $this->leagues($input);
        $league_data = $league_raw[0]['data'];

        $input['leagues']    =   $league_data;

        $game_array = [];
        $gameData = $this->games($input);

        if ($gameData['status'] && !empty($gameData['data'])) {
            $response = $gameData['data'];
            $count = 0;
            
            foreach ($response['data'] as $game) {
                $count++;

                    // SportsBook
                    // $sports_book_input = ['game_id' => $game['id']];
                    // $sports_book = $this->sportsBook($sports_book_input);
                    // $sports_book_data = $sports_book[0]['data'];

                    // SportsBook
                    $sports_book_data = $this->defaultSporksBook();

                    $home_team = $game['home_team_info'];
                    $away_team = $game['away_team_info'];

                if ( isset($home_team) && isset($away_team) ) {

                    $upcomingGameOddsInput = [];
                    $upcomingGameOddsInput['game_id']    =   $game['id'];
                    $upcomingGameOddsInput['team_id']    =   $home_team['id'];
                    
                    // Retrieve odds per team
                    // Home Team
                    $upcomingGameOddsHomeTeam = $this->upcomingGameOdds($upcomingGameOddsInput);

                    // Away Team
                    $upcomingGameOddsInput['team_id']    =   $away_team['id'];
                    $upcomingGameOddsAwayTeam = $this->upcomingGameOdds($upcomingGameOddsInput);

                    $market_input = [];
                    $market_input['game_id'] = $game['id'];
                    $market_input['leagues'] =   ['WTA'];
                    $market_input['sports']  =   ['tennis'];
                    $market_query = $this->markets($market_input);
                    $market_categories_query = $this->marketCategories($market_input);

                    array_push($game_array, [
                        'game' => $game,
                        // 'sports_book' => $sports_book_data,
                        'home_team_odds' =>  $upcomingGameOddsHomeTeam['data'][0]['odds'],
                        'away_team_odds' => $upcomingGameOddsAwayTeam['data'][0]['odds'],
                        // 'market'  => $market_query[0]['data'],
                        // 'market_categories' =>  $market_categories_query[0]['data'],
                    ]);

                    dd($game_array);

                }
                    
            }

        }




        
    }

}
