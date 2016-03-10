<?php

namespace App\Http\Controllers;

use App\Services\UploadFileService;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class UploadFileController extends Controller
{

    // services
    public  $uploadFileService =null;

    public function __construct(){
        // initialize benefiters list service
        $this->uploadFileService = new UploadFileService();
    }


    // returns upload csv view
    public function getUploadCSV(){
        return view('uploadExcel');
    }

    // uploads the file to server
    public function excelUpload(){
        // instantiate the upload file service
        $uploadFileService = new UploadFileService();
        // get the file from the post request
        $file = Input::file('file');
        // set file name
        $filename = Carbon::now('Europe/Athens') . '-' . $file->getClientOriginalName();
        // set file path
        $filepath = public_path() . '/uploads/uploadedExcels/';
        // move file to correct location
        $file->move($filepath, $filename);
        $fullFilePath = $filepath . $filename;
        // Insert upload main info (file name & date) to DB
        $uploadFileService->importedFilesTable();
        // insert values to DB
        return $uploadFileService->fileImport($fullFilePath);
    }
//
//
//    //---------------------------------------------------//
//    //---- TO BE DELETED LATER (test outputs) -----------//
//
//    public function testData(){
//        $benefiter_id = 2;
//        $singleRowTestArray = array('folder_number' => 'ΚΚ1',
//            'has_social_reference' => 'ναι',
//            'social_reference_actions' => 'Κ-ενεργεια α',
//            'social_reference_date' => '14-5-2016',
//            'has_medical_reference' => 'ναι',
//            'medical_reference_actions' => 'ι-ενεργεια α',
//            'medical_reference_date' => '14-5-2016',
//            'has_legal_reference' => 'ναι',
//            'legal_reference_actions' => 'ν-ενεργεια α',
//            'legal_reference_date' => '14-5-2016',
//            'has_educational_reference' => 'οχι',
//            'educational_reference_actions' => 'ν-ενεργεια β',
//            'educational_reference_date' => '14-5-2016',);
//        $this->uploadFileService->selectOnlyReferrals($singleRowTestArray, $benefiter_id);
//    }
}
