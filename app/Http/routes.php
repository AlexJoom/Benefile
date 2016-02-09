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

Route::get('/', function () {
    return view('auth.login');
});


Route::get('home', 'HomeController@index');

/*
 * Layout after login
 */
Route::get('awaitingActivation', function () {
    return view('auth.awaitActivation');
});
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);




// MAIN PANEL ROUTES //

Route::get('main-panel', function () {
    return view('layouts.mainPanel');
});

Route::get('main-panel/users-list', 'MainPanel\UsersController@getUsers');
Route::get('main-panel/reports', 'MainPanel\ReportsController@getReports');

// END MAIN PANEL ROUTES //