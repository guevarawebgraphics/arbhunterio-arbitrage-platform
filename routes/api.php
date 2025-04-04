<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Upcoming Games & Odds
Route::get('/games', '\App\Http\Controllers\Api\APIController@getGames')->name('api.games');

Route::get('/leagues', '\App\Http\Controllers\Api\APIController@getLeagues')->name('api.leagues');
Route::get('/upcoming-odds', '\App\Http\Controllers\Api\APIController@getUpcomingGameOdds')->name('api.upcoming.game.odds');
Route::get('/market-categories', '\App\Http\Controllers\Api\APIController@getMarketCategories')->name('api.market.categories');
Route::get('/markets', '\App\Http\Controllers\Api\APIController@getMarkets')->name('api.market');
Route::get('/upcoming-odds-push-streams', '\App\Http\Controllers\Api\APIController@getUpcomingOddsPushStreams')->name('api.upcoming.odds.push.streams');

// Futures & Odds
Route::get('/future-odds', '\App\Http\Controllers\Api\APIController@getFutureOdds')->name('api.future.odds');
Route::get('/futures', '\App\Http\Controllers\Api\APIController@getFutures')->name('api.futures');

// Player Results
Route::get('/best-grader', '\App\Http\Controllers\Api\APIController@getBestGrader')->name('api.best.grader');

Route::get('/game-scores', '\App\Http\Controllers\Api\APIController@getGameScores')->name('api.game.scores');

Route::get('/player-results', '\App\Http\Controllers\Api\APIController@getPlayerResults')->name('api.player.results');

// Base
Route::get('/teams', '\App\Http\Controllers\Api\APIController@getTeams')->name('api.teams');

Route::get('/players', '\App\Http\Controllers\Api\APIController@getPlayers')->name('api.players');


// Detailed Game Listing
Route::get('/game-listing', '\App\Http\Controllers\Api\APIController@getGameListing')->name('api.game.listing');

Route::post('fetch/odds', '\App\Http\Controllers\Api\APIController@fetchOddsData')->name('api.game.fetch.odds');

Route::get('/game-listing/paginate', '\App\Http\Controllers\Api\APIController@getGameListingPaginate')->name('api.game.listing.paginate');

Route::get('/odds-push-streams', '\App\Http\Controllers\Api\APIController@oddsPushStream')->name('api.odds.push.streams');

Route::get('/test-api', '\App\Http\Controllers\Api\APIController@testApi')->name('test.api');

Route::get('/game/{id}/bet_type/{bet_type}','\App\Http\Controllers\Api\APIController@getGameInfo')->name('api.games.info');

Route::get('/game/{gameId}/hidden/{betType}/status/{statusId}','\App\Http\Controllers\Api\APIController@updateGameHidden')->name('api.game.hidden.status');

Route::post('save/filter', '\App\Http\Controllers\Api\APIController@storeFilter')->name('api.store.filter');

Route::get('filters/{user_id}', '\App\Http\Controllers\Api\APIController@indexFilters')->name('api.filters');

Route::get('filter/delete/{id}', '\App\Http\Controllers\Api\APIController@destroyFilter')->name('api.filter.destroy');

Route::get('filter/{id}', '\App\Http\Controllers\Api\APIController@getFilter')->name('api.filter.item');

