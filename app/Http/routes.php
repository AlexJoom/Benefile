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

Route::get('disabledUser', function(){
    return view('auth.disabledUser');
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
Route::get('benefiter/{id}/delete', 'MainPanel\RecordsController@getDeleteBenefiter');
//--- END ΟΦΕΛΟΥΜΕΝΟΙ
//--- ΕΓΓΡΑΦΗ
//----------- ΝΕΑ ΕΓΓΡΑΦΗ
//----------------------- BASIC INFO
Route::get('benefiter/{id}/basic-info', 'MainPanel\RecordsController@getBasicInfo');
Route::post('benefiter/{id}/basic-info', 'MainPanel\RecordsController@postBasicInfo');
Route::post('benefiter/{id}/basic-info/referrals', 'MainPanel\RecordsController@postBasicInfoReferrals');
//----------------------- END BASIC INFO

//----------------------- MEDICAL FOLDER
Route::get('benefiter/{id}/medical-folder', 'MainPanel\RecordsController@getMedicalFolder');
Route::post('benefiter/{id}/medical-folder', 'MainPanel\RecordsController@postMedicalFolder');
Route::get('benefiter/getIC10List', 'MainPanel\RecordsController@getICD10List');
Route::get('benefiter/getMedicationList', 'MainPanel\RecordsController@getMedicationList');
Route::get('benefiter/{id}/getEachMedicalVisit', 'MainPanel\RecordsController@getMedicalVisitModal');
Route::get('benefiter/{id}/editMedicalVisit', 'MainPanel\RecordsController@getMedicalVisitForEditing');

//----------------------- END MEDICAL FOLDER

//----------------------- LEGAL FOLDER
Route::get('benefiter/{id}/legal-folder', 'MainPanel\RecordsController@getLegalFolder');
Route::post('benefiter/{id}/legal-folder', 'MainPanel\RecordsController@postLegalFolder');
//----------------------- END LEGAL FOLDER

//----------------------- SOCIAL FOLDER
Route::get('benefiter/{id}/social-folder', 'MainPanel\RecordsController@getSocialFolder');
Route::post('benefiter/{id}/social-folder', 'MainPanel\RecordsController@postSocialFolder');
Route::post('benefiter/{id}/session-save', 'MainPanel\RecordsController@postSessionSave');
Route::post('benefiter/{id}/session-edit/{session_id}', 'MainPanel\RecordsController@postSessionEdit');
Route::get('benefiter/{id}/session-delete/{session_id}', 'MainPanel\RecordsController@getSessionDelete');
//----------------------- END SOCIAL FOLDER
//----------- END ΝΕΑ new-benefiter/medical-folderΕΓΓΡΑΦΗ

//----------- ΦΟΡΤΩΣΗ ΑΡΧΕΙΟΥ
Route::get('new-benefiter/uploadCSV', 'UploadFileController@getUploadCSV');
Route::post('new-benefiter/uploadCSV', 'UploadFileController@excelUpload');
//----------- END ΦΟΡΤΩΣΗ ΑΡΧΕΙΟΥ
//--- END ΕΓΓΡΑΦΗ

//--- ΑΝΑΖΗΤΗΣΗ
Route::get('search', 'MainPanel\SearchController@getSearch');
Route::get('results', 'MainPanel\SearchController@getResults');
//--- END ΑΝΑΖΗΤΗΣΗ

//--- ΑΝΑΦΟΡΑ
Route::get('main-panel/reports', 'MainPanel\ReportsController@getReports');
//--- END ΑΝΑΦΟΡΑ

//--- ΧΡΗΣΤΕΣ
Route::get('main-panel/users-list', 'MainPanel\UsersController@UsersList');
Route::post('main-panel/users-list', 'MainPanel\UsersController@UserStatusUpdate');
//--- END ΧΡΗΣΤΕΣ

// END OF MAIN PANEL MENU





