<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadFile extends Controller
{
    public function excelUpload(Request $request){
        // get the file from the post request
        $file = $request->file('file');
        // set file name
        $filename = unique() . $file->getClientOriginalName();
        // Accept only excel files
        // TODO
        // move file to correct location
        $file->move('uploadedExcelFiles', $filename);

        // save file details in database
        // make model for excel files (???) Probably the relation between the db tables
        // maybe i need a db table for the uploaded files

    }
}
