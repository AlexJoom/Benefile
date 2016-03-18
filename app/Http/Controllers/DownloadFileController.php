<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DownloadFileController extends Controller
{
    // expects .json and returns a .csv file
    public function getDownloadCSV(Request $request){
        dd($request->all()['benefiters_found_ids']);
    }
}
