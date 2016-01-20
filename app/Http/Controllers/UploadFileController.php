<?php

namespace App\Http\Controllers;



use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Maatwebsite\Excel;


class UploadFileController extends Controller{

    public function excelUpload(){
        // get the file from the post request
        $file = Input::file('file');
        // set file name
        $filename =Carbon::now('Europe/Athens') .'-' . $file->getClientOriginalName();
        // move file to correct location
        $file->move('../uploadedExcels', $filename);
        $filePath = '/uploadedExcels/'. $filename;

        return $this -> excelImport($filePath);
    }

    public function excelImport($filePath){
        // Import csv
        return $filePath;
//        Excel::load($filePath, function($reader) {
//
//            $results = $reader->get();
//
//        });
        // save file details in database
        // make model for excel files (???) Probably the relation between the db tables
        // maybe i need a db table for the uploaded files
    }

}
