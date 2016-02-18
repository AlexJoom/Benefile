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

// MAIN PANEL MENU
//--- ΟΦΕΛΟΥΜΕΝΟΙ
Route::get('benefiters-list', 'MainPanel\RecordsController@getBenefitersList');
//--- END ΟΦΕΛΟΥΜΕΝΟΙ
//--- ΕΓΓΡΑΦΗ
//----------- ΝΕΑ ΕΓΓΡΑΦΗ
//----------------------- BASIC INFO
Route::get('new-benefiter/basic-info', 'MainPanel\RecordsController@getBasicInfo');
Route::post('new-benefiter/basic-info', 'MainPanel\RecordsController@postBasicInfo');
//----------------------- END BASIC INFO

//----------------------- MEDICAL FOLDER
Route::get('/new-benefiter/medical-folder', 'MainPanel\RecordsController@getMedialFolder');
Route::post('/new-benefiter/medical-folder', 'MainPanel\RecordsController@postMedicalFolder');
//----------------------- END MEDICAL FOLDER

//----------------------- LEGAL FOLDER
//----------------------- END LEGAL FOLDER

//----------------------- SOCIAL FOLDER
Route::get('new-benefiter/social-folder', 'MainPanel\RecordsController@getSocialFolder');
Route::post('new-benefiter/social-folder', 'MainPanel\RecordsController@postSocialFolder');
//----------------------- END SOCIAL FOLDER
//----------- END ΝΕΑ new-benefiter/medical-folderΕΓΓΡΑΦΗ

//----------- ΦΟΡΤΩΣΗ ΑΡΧΕΙΟΥ
Route::get('new-benefiter/uploadCSV', 'UploadFileController@getUploadCSV');
Route::post('new-benefiter/uploadCSV', 'UploadFileController@excelUpload');
//----------- END ΦΟΡΤΩΣΗ ΑΡΧΕΙΟΥ
//--- END ΕΓΓΡΑΦΗ

//--- ΑΝΑΦΟΡΑ
Route::get('main-panel/reports', 'MainPanel\ReportsController@getReports');
//--- END ΑΝΑΦΟΡΑ

//--- ΧΡΗΣΤΕΣ
Route::get('main-panel/users-list', 'MainPanel\UsersController@UsersList');
Route::post('main-panel/users-list', 'MainPanel\UsersController@UserStatusUpdate');
//--- END ΧΡΗΣΤΕΣ

// END OF MAIN PANEL MENU






