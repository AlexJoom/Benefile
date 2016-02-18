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
    // services
    private $basicInfoService;
    private $socialFolderService;

    public function __construct(){
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize social folder service
        $this->socialFolderService = new SocialFolderService();
    }

    // get basic info view
    public function getBasicInfo($id){
        $languages = $this->basicInfoService->getAllLanguages();
        $languageLevels = $this->basicInfoService->getAllLanguageLevels();
        $legal_statuses = null;
        $benefiterLanguagesAndLevels = null;
        // checks if id is correct, so it could find the existent benefiter with that id
        if($id > 0){
            $benefiter = $this->basicInfoService->findExistentBenefiter($id);
            if($benefiter == null) {
                return "Page not found.";
            } else {
                $legal_statuses = $this->basicInfoService->getLegalStatusesByBenefiterId($id);
                $benefiterLanguagesAndLevels = $this->basicInfoService->getLanguagesAndLanguagesLevelsByBenefiterId($id);
            }
        } else {
            $benefiter = new Benefiter();
        }
        return view('benefiter.basic_info')->with("languages", $languages)->with("languageLevels", $languageLevels)->with("benefiter", $benefiter)->with("legal_statuses", $legal_statuses)->with("benefiter_languages", $benefiterLanguagesAndLevels);
    }

    // post from basic info form
    public function postBasicInfo(Request $request){
        $languages = $this->basicInfoService->getAllLanguages();
        $languageLevels = $this->basicInfoService->getAllLanguageLevels();
        $validator = $this->basicInfoService->basicInfoValidation($request->all());
        if($validator->fails()){
            return view('benefiter.basic_info')->with("languages", $languages)->with("languageLevels", $languageLevels)->with("benefiter", new Benefiter())->withErrors($validator->errors()->all());
        } else {
            $benefiter = $this->basicInfoService->saveBasicInfoToDB($request->all());
            $legal_statuses = $this->basicInfoService->getLegalStatusesByBenefiterId($benefiter->id);
            $benefiterLanguagesAndLevels = $this->basicInfoService->getLanguagesAndLanguagesLevelsByBenefiterId($benefiter->id);
            return view('benefiter.basic_info')->with("languages", $languages)->with("languageLevels", $languageLevels)->with("benefiter", $benefiter)->with("legal_statuses", $legal_statuses)->with("benefiter_languages", $benefiterLanguagesAndLevels);
        }
    }

    // get social folder view
//    public function getSocialFolder(){
//        $psychosocialSubjects = $this->socialFolderService->getAllPsychosocialSupportSubjects();
//        return view('benefiter.social_folder')->with("tab", "social")->with("psychosocialSubjects", $psychosocialSubjects);
//    }
//
//    // post from social folder form
//    public function postSocialFolder(Request $request){
//        $validator = $this->socialFolderService->socialFolderValidation($request->all());
//        if($validator->fails()){
//            return view('benefiter.social_folder')->withErrors($validator->errors()->all());
//        } else {
//            $this->socialFolderService->saveSocialFolderToDB($request->all(), $this->benefiter->id);
//            return 'success';
//        }
//    }

    // Get Medical folder of benefiter
    public function getMedialFolder(){
        return view('benefiter.medical-folder');
    }
}
