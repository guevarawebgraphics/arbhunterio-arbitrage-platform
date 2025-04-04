<?php

/*
|--------------------------------------------------------------------------
| Main Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "main" middleware group. Now create something great!
|
*/

Route::group(
    [
        "middleware" => ['isFront', 'revalidate'],
    ], function () {

    /* dashboard routes */
    Route::get('/', function () {
        return redirect('dashboard');
    });

    Route::get('/dashboard', [
        'uses' => '\App\Http\Controllers\FrontDashboardController@index',
        'as' => 'dashboard',
    ]);

    Route::get('/orders', [
        'uses' => '\App\Http\Controllers\OrderController@indexOrders',
        'as' => 'orders',
    ]);

    Route::get('/address', [
        'uses' => '\App\Http\Controllers\UserController@indexAddress',
        'as' => 'address',
    ]);

    Route::put('/address/update/{id}', [
        'uses' => '\App\Http\Controllers\UserController@updateAddress',
        'as' => 'address.update',
    ]);

    Route::get('/account-details', [
        'uses' => '\App\Http\Controllers\UserController@indexAccountDetails',
        'as' => 'account-details',
    ]);

    Route::put('/account-details/update/{id}', [
        'uses' => '\App\Http\Controllers\UserController@updateAccountDetails',
        'as' => 'account-details.update',
    ]);

    Route::get('/calculators/arbitrage', [
        'uses' => '\App\Http\Controllers\FrontDashboardController@indexArbitrageHedgeCalculator',
        'as' => 'calculator.arbitrage',
    ]);


    Route::get('/calculators/bet-conversion', [
        'uses' => '\App\Http\Controllers\FrontDashboardController@indexBetConversion',
        'as' => 'calculator.bet_conversion',
    ]);
    
    Route::get('/bet-tracker', [
        'uses' => '\App\Http\Controllers\FrontDashboardController@indexBetTracker',
        'as' => 'bet.tracker',
    ]);

});

Route::group(
    [
        "middleware" => ['revalidate'],
    ], function () {

    /* contacts */
    Route::post('/contact/store', [
        'uses' => '\App\Http\Controllers\Admin\ContactController@store',
        'as' => 'contact.store'
    ]);
    /* contact */

    /* newsletter */
    Route::post('/newsletters/store', [
        'uses' => '\App\Http\Controllers\Admin\NewsletterController@store',
        'as' => 'newsletters.store'
    ]);
    /* newsletter */

    Route::get('/{slug?}', '\App\Http\Controllers\PageController@showPages');

    Route::get('blog/{slug?}', '\App\Http\Controllers\Admin\BlogController@details')->name('blog.details');
        
    Route::get('blog/category/{category?}', '\App\Http\Controllers\Admin\BlogController@categories')->name('blog.categories');
});