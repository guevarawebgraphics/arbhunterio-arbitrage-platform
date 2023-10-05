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

    // profile

    Route::get('/account-details/overview', [
        'uses' => '\App\Http\Controllers\UserController@overviewAccountDetails',
        'as' => 'account-details.overview',
    ]);

    Route::get('/account-details/general-settings', [
        'uses' => '\App\Http\Controllers\UserController@generalSettingsAccountDetails',
        'as' => 'account-details.general_settings',
    ]);

    Route::get('/account-details/manage-subscription', [
        'uses' => '\App\Http\Controllers\UserController@manageSubscriptionAccountDetails',
        'as' => 'account-details.manage_subscription',
    ]);

    Route::get('/account-details/manage-filters', [
        'uses' => '\App\Http\Controllers\UserController@manageFiltersAccountDetails',
        'as' => 'account-details.manage_filters',
    ]);

    Route::get('/account-details/bet-tracker-notifications', [
        'uses' => '\App\Http\Controllers\UserController@betTrackerNotificationAccountDetails',
        'as' => 'account-details.bet_tracker_notifications',
    ]);

    Route::get('/account-details/bankroll-settings', [
        'uses' => '\App\Http\Controllers\UserController@bankrollSettingsAccountDetails',
        'as' => 'account-details.bankroll_settings',
    ]);

    Route::get('/account-details/manage-injury-notifications', [
        'uses' => '\App\Http\Controllers\UserController@manageInjuryNotificationsAccountDetails',
        'as' => 'account-details.manage_injury_notifications',
    ]);

    Route::get('/account-details/betting-tool-notifications', [
        'uses' => '\App\Http\Controllers\UserController@bettingToolNotificationsAccountDetails',
        'as' => 'account-details.betting_injury_notifications',
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