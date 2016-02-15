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
    private $basicInfoService;

    public function __construct(){
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
    }

    // get basic info view
    public function getBasicInfo(){
        $languages = $this->basicInfoService->getAllLanguages();
        $languageLevels = $this->basicInfoService->getAllLanguageLevels();
        return view('benefiter.basic_info')->with("languages", $languages)->with("languageLevels", $languageLevels);
    }

    // post from basic info form
    public function postBasicInfo(Request $request){
        $validator = $this->basicInfoService->basicInfoValidation($request->all());
        if($validator->fails()){
            return view('benefiter.basic_info')->withErrors($validator->errors()->all());
        } else {
            $this->basicInfoService->saveBasicInfoToDB($request->all());
            return 'success';
        }
    }
}
