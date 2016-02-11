<?php

namespace App\Http\Controllers\MainPanel;

use App\Models\Benefiters_Tables_Models\Benefiter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\BasicInfoService;
use Validator;

class RecordsController extends Controller
{
    // get basic info view
    public function getBasicInfo(){
        return view('records.basic_info');
    }

    // post from basic info form
    public function postBasicInfo(Request $request){
        $basicInfoService = new BasicInfoService();
//        dd($request->request->all());
        if($basicInfoService->basicInfoValidation($request)->fails()){
            return 'fail';
        } else {
            return 'success';
        }
//        dd($basicInfoService->basicInfoValidation($request));
    }
}
