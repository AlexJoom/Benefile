<?php

namespace App\Http\Controllers\MainPanel;

use App\Models\Benefiters_Tables_Models\Benefiter;
use app\Services\BenefitersService;
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
    private $languages;
    private $languageLevels;
    private $benefiterList = null;

    public function __construct(){
        // initialize benefiters list service
        $this->benefiterList = new BenefitersService();
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize social folder service
        $this->socialFolderService = new SocialFolderService();
        // initialize medical visit service
        $this->medicalVisit = new BenefiterMedicalFolderService();
        // set $languages and $languagesLevels
        $this->languages = $this->basicInfoService->getAllLanguages();
        $this->languageLevels = $this->basicInfoService->getAllLanguageLevels();
    }

    // Get Benefiters list
    public function getBenefitersList(){
        $benefitersList =  $this->benefiterList->getAllBenefiters();
        return view('benefiter.benefiters_list', compact('benefitersList'));
    }

    // get basic info view
    public function getBasicInfo(){
        return view('benefiter.basic_info')->with("languages", $this->languages)->with("languageLevels", $this->languageLevels);
    }

    // post from basic info form
    public function postBasicInfo(Request $request){
        $validator = $this->basicInfoService->basicInfoValidation($request->all());
        if($validator->fails()){
            return view('benefiter.basic_info')->with("languages", $this->languages)->with("languageLevels", $this->languageLevels)->withErrors($validator->errors()->all());
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
