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


Route::get('home', 'MainPanel\RecordsController@getBenefitersList');

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
Route::get('benefiter/{id}/basic-info/referral-delete/{referral_id}', 'MainPanel\RecordsController@deleteBasicInfoReferral');
//----------------------- END BASIC INFO

//----------------------- MEDICAL FOLDER
Route::get('benefiter/{id}/medical-folder'      , 'Medical_Folder\NewMedicalVisitController@getMedicalFolder');
Route::post('benefiter/{id}/medical-folder'     , 'Medical_Folder\NewMedicalVisitController@postMedicalFolder');
Route::get('benefiter/getIC10List'              , 'Medical_Folder\MedicalFolderExtraFunctionsController@getICD10List');
Route::get('benefiter/getMedicationList'        , 'Medical_Folder\MedicalFolderExtraFunctionsController@getMedicationList');
Route::get('benefiter/{id}/getEachMedicalVisit' , 'Medical_Folder\MedicalFolderExtraFunctionsController@getMedicalVisitModal');
Route::get('benefiter/{id}/editMedicalVisit'    , 'Medical_Folder\EditMedicalVisitController@getMedicalVisitForEditing');
Route::post('benefiter/{id}/editMedicalVisit'   , 'Medical_Folder\EditMedicalVisitController@postMedicalVisitFromEditing');

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

//// --- to be deleted later  ---//
//Route::get('new-benefiter/uploadCSV/dataTester', 'UploadFileController@testData');

//----------- END ΦΟΡΤΩΣΗ ΑΡΧΕΙΟΥ
//--- END ΕΓΓΡΑΦΗ

//--- ΑΝΑΖΗΤΗΣΗ
Route::get('search', 'MainPanel\SearchController@getSearch');
Route::get('results', 'MainPanel\SearchController@getResults');
//--- END ΑΝΑΖΗΤΗΣΗ

//--- ΑΝΑΦΟΡΑ
Route::get('reports', 'MainPanel\ReportsController@getReports');
Route::get('reports-search-results', 'MainPanel\ReportsController@getBenefiterSearchResults');
Route::get('download-csv', 'DownloadFileController@getDownloadCSV');
Route::get('benefites-VS-education-Report-get-data', 'MainPanel\ReportsController@getBenefitesVSeducationdata');
Route::get('benefites-VS-doctor-Report-get-data', 'MainPanel\ReportsController@getBenefitesVSdoctorsData');
Route::get('benefites-VS-ClinicalConditions-Report-get-data', 'MainPanel\ReportsController@getBenefitesVSClinicalConditionsData');
Route::get('medical_visits-PER-month-Report-get-data', 'MainPanel\ReportsController@getMedicalVisitsVSMonthDate');
Route::get('benefites-VS-phycological-support-type', 'MainPanel\ReportsController@getBenefitersVSPhycologicalSupportType');
Route::get('registrations-PER-month-Report-get-data', 'MainPanel\ReportsController@getRegistrationsVSMonthDate');
//--- END ΑΝΑΦΟΡΑ

//--- ΧΡΗΣΤΕΣ
Route::get('main-panel/users-list', 'MainPanel\UsersController@UsersList');
Route::post('main-panel/users-list', 'MainPanel\UsersController@UserStatusUpdate');
//--- END ΧΡΗΣΤΕΣ

// END OF MAIN PANEL MENU





