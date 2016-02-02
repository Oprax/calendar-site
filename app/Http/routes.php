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
/*
Route::group(['prefix' => 'oauth'], function(){
    Route::post('access_token', function() {
        return Response::json(Authorizer::issueAccessToken());
    });
});
*/
/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
*/

// Set value to null if you're not HTTPS
Route::group(['prefix' => 'auth', 'middleware' => 'secure'], function ()
{
    Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);

    // Registration routes...
    //Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
    //Route::post('register', 'Auth\AuthController@postRegister');
});

Route::group(['prefix' => 'password', 'middleware' => 'secure'], function ()
{
    // Password reset link request routes...
    Route::get('email', ['as' => 'auth.email', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post('email', 'Auth\PasswordController@postEmail');

    // Password reset routes...
    Route::get('reset/{token}', ['as' => 'auth.resetToken', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post('reset', ['as' => 'auth.reset', 'uses' => 'Auth\PasswordController@postReset']);
});
