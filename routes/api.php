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
Route::get('/games', '\App\Http\Controllers\Api\APIController@games')->name('api.games');
Route::get('/leagues', '\App\Http\Controllers\Api\APIController@leagues')->name('api.leagues');
Route::get('/upcoming-odds', '\App\Http\Controllers\Api\APIController@upcomingGameOdds')->name('api.upcoming.game.odds');

// Futures & Odds
Route::get('/future-odds', '\App\Http\Controllers\Api\APIController@futureOdds')->name('api.future.odds');
Route::get('/futures', '\App\Http\Controllers\Api\APIController@futures')->name('api.futures');

// Player Results
Route::get('/best-grader', '\App\Http\Controllers\Api\APIController@bestGrader')->name('api.best.grader');
Route::get('/game-scores', '\App\Http\Controllers\Api\APIController@gameScores')->name('api.game.scores');
Route::get('/player-results', '\App\Http\Controllers\Api\APIController@playerResults')->name('api.player.results');

// Base
Route::get('/teams', '\App\Http\Controllers\Api\APIController@teams')->name('api.teams');
Route::get('/players', '\App\Http\Controllers\Api\APIController@players')->name('api.players');