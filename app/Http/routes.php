<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'welcome', function(){
    return view('welcome');
}]);

Route::get('home', function(){
    return redirect()->route('welcome');
});

Route::resource('reservations', 'ReservationUIController');

Route::get('calendar/{year}/{month?}/{day?}', ['uses' => 'CalendarController@main', 'as' => 'calendar.main'])
->where(['year' => '20\d\d', 'month' => '\d{1,2}', 'day' => '\d{1,2}']);

Route::get('stats', ['uses' => 'StatsController@index', 'as' => 'stats.index']);

Route::get('stats/{year}', ['uses' => 'StatsController@chart', 'as' => 'stats.chart'])
->where(['year' => '20\d\d']);

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api'], function(){
    Route::resource('reservations', 'ReservationAPIController');
});

/*
|--------------------------------------------------------------------------
| OAuth2 routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'oauth'], function(){
    Route::post('access_token', function() {
        return Response::json(Authorizer::issueAccessToken());
    });
});

/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
*/

// Set value to null if you're not HTTPS
Route::group(['middleware' => 'secure'], function ()
{
    Route::get('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);
});

// Registration routes...
//Route::get('auth/register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
//Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', ['as' => 'auth.email', 'uses' => 'Auth\PasswordController@getEmail']);
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', ['as' => 'auth.resetToken', 'uses' => 'Auth\PasswordController@getReset']);
Route::post('password/reset', ['as' => 'auth.reset', 'uses' => 'Auth\PasswordController@postReset']);
