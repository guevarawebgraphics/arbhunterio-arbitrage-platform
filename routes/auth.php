<?php

//use App\Services\SystemSettings\SystemSetting;
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

/* for site restriction post */
Route::post('/site_restricted', ['as' => 'site_restricted', 'uses' => 'SiteRestrictedController@index']);
//Route::post('/site_restricted', 'SiteRestrictedController@index')->name('site_restricted');
Route::group(
    [
        "middleware" => ['revalidate'],
    ], function () {

    /*
    * Admin
    */
    /* Login Routes */

    Route::get('/admin/login', ['as' => 'admin.login', 'uses' => 'Admin\Auth\LoginController@showLoginForm']);
    Route::post('/admin/login', ['as' => 'admin.login.post', 'uses' => 'Admin\Auth\LoginController@login']);
    Route::get('/admin/logout', ['as' => 'admin.logout', 'uses' => 'Admin\Auth\LoginController@logout']);
    Route::post('/admin/logout', ['as' => 'admin.logout.post', 'uses' => 'Admin\Auth\LoginController@logout']);

    /* Login Routes */
    Route::get('/user/login', ['as' => 'user.login', 'uses' => 'Front\Auth\LoginController@showLoginForm']);
    Route::post('/user/login', ['as' => 'user.login.post', 'uses' => 'Front\Auth\LoginController@login']);
    Route::get('/user/logout', ['as' => 'user.logout', 'uses' => 'Front\Auth\LoginController@logout']);
    Route::post('/user/logout', ['as' => 'user.logout.post', 'uses' => 'Front\Auth\LoginController@logout']);

    /* Registration Routes */
    //if (SystemSetting::where('code', 'BJCDL_010')->first()->value == 1) {
        Route::get('/user/register', ['as' => 'user.register', 'uses' => 'Front\Auth\RegisterController@showRegistrationForm']);
        Route::post('/user/register', ['as' => 'user.register.post', 'uses' => 'Front\Auth\RegisterController@register']);
    //}

    /* Forgot Password Routes */
    Route::get('/user/password/email', ['as' => 'user.password.email', 'uses' => 'Front\Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('/user/password/email', ['as' => 'user.password.email.post', 'uses' => 'Front\Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('/user/password/reset/{token}', ['as' => 'user.password.reset', 'uses' => 'Front\Auth\ResetPasswordController@showResetForm']);
    Route::post('/user/password/reset', ['as' => 'user.password.reset.post', 'uses' => 'Front\Auth\ResetPasswordController@reset']);
});