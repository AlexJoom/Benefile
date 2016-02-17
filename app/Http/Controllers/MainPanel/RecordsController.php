<?php

namespace App\Http\Controllers\MainPanel;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Services\SocialFolderService;
use App\Services\BenefiterMedicalFolderService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\BasicInfoService;
use Validator;

class RecordsController extends Controller
{
    private $basicInfoService;
    private $socialFolderService;
    private $medicalVisit;

    public function __construct(){
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize social folder service
        $this->socialFolderService = new SocialFolderService();
        // initialize medical visit service
        $this->medicalVisit = new BenefiterMedicalFolderService();
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

    // get social folder view
    public function getSocialFolder(){
        return view('benefiter.social_folder')->with("tab", "social");
    }

    // post from social folder form
    public function postSocialFolder(Request $request){
        $validator = $this->socialFolderService->socialFolderValidation($request->all());
        if($validator->fails()){
            return view('benefiter.social_folder')->withErrors($validator->errors()->all());
        } else {
            return 'success';
        }
    }

    // Get Medical visit data of benefiter
    public function getMedialFolder(){
        // in addition the repeaded data will be send to the medical folder/visit
        return view('benefiter.medical-folder');
    }
    // POST Medical visit data
    public function postMedicalFolder(Request $request){
//        dd($request->all());
//        $validator = $this->medicalVisit->medicalValidation($request->all());
//        if($validator->fails()){
//            return view('benefiter.medical-folder')->withErrors($validator->errors()->all());
//        } else {
            $this->medicalVisit->saveToDB($request->all());
            return 'success';
//        }


        // in addition the repeaded data will be send to the medical folder/visit
//        return view('benefiter.medical-folder');
    }
}
