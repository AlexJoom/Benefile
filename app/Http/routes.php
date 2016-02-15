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

Route::get('main-panel', 'HomeController@index');

//Route::get('main-panel/users-list', function () {
//    return view('userPanel.users-list');
//});

// start of records menu
Route::get('new-benefiter/basic-info', 'MainPanel\RecordsController@getBasicInfo');
Route::post('new-benefiter/basic-info', 'MainPanel\RecordsController@postBasicInfo');

Route::get('/new-benefiter/medical-folder', 'MainPanel\RecordsController@getMedialFolder');
// end of records menu



Route::post('main-panel/users-list', 'MainPanel\UsersController@UserStatusUpdate');
Route::get('main-panel/users-list', 'MainPanel\UsersController@UsersList');

Route::get('main-panel/reports', 'MainPanel\ReportsController@getReports');

// END MAIN PANEL ROUTES //
