<?php

namespace App\Http\Controllers\MainPanel;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Services\SocialFolderService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\BasicInfoService;
use Validator;

class RecordsController extends Controller
{
    private $basicInfoService;
    private $socialFolderService;

    public function __construct(){
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize social folder service
        $this->socialFolderService = new SocialFolderService();
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

    // Get Medical folder of benefiter
    public function getMedialFolder(){
        return view('benefiter.medical-folder');
    }
}
