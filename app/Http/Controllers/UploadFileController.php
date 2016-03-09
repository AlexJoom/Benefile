<?php

namespace App\Http\Controllers;

use App\Services\UploadFileService;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class UploadFileController extends Controller
{
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
        // insert values to DB
        $uploadFileService->fileImport($fullFilePath);
    }
}
