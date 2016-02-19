<?php

namespace App\Http\Controllers\MainPanel;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\medical_examination_results_lookup;
use App\Services\SocialFolderService;
use App\Services\BenefiterMedicalFolderService;
use App\Services\BenefitersService;
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
    private $medicalVisit;
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
    }

    // GET BENEFITERS LIST
    public function getBenefitersList(){
        $benefiters =  $this->benefiterList->getAllBenefiters();
//        dd($benefiters);
        return view('benefiter.benefiters_list', compact('benefiters'));
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
                return view('errors.404');
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
    public function getSocialFolder($id){
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        if($benefiter == null) {
            return view('errors.404');
        } else {
            $socialFolder = $this->socialFolderService->getSocialFolderFromBenefiterId($id);
            if($socialFolder == null){
                return view('errors.404');
            } else {
                $psychosocialSubjects = $this->socialFolderService->getAllPsychosocialSupportSubjects();
                $psychosocialSupport = $this->socialFolderService->getBenefiterPsychosocialSupport($id);
                return view('benefiter.social_folder')->with("tab", "social")->with("psychosocialSubjects", $psychosocialSubjects)->with("benefiter", $benefiter)->with("social_folder", $socialFolder)->with("psychosocial_support", $psychosocialSupport);
            }
        }
    }

    // post from social folder form
    public function postSocialFolder(Request $request, $id){
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $psychosocialSubjects = $this->socialFolderService->getAllPsychosocialSupportSubjects();
        $socialFolder = null;
        $psychosocialSupport = null;
        $validator = $this->socialFolderService->socialFolderValidation($request->all());
        if($validator->fails()){
            return view('benefiter.social_folder')->with("tab", "social")->with("psychosocialSubjects", $psychosocialSubjects)->with("benefiter", $benefiter)->with("social_folder", $socialFolder)->with("psychosocial_support", $psychosocialSupport)->withErrors($validator->errors()->all());
        } else {
            $this->socialFolderService->saveSocialFolderToDB($request->all(), $id);
            $socialFolder = $this->socialFolderService->getSocialFolderFromBenefiterId($id);
            $psychosocialSupport = $this->socialFolderService->getBenefiterPsychosocialSupport($id);
            return view('benefiter.social_folder')->with("tab", "social")->with("psychosocialSubjects", $psychosocialSubjects)->with("benefiter", $benefiter)->with("social_folder", $socialFolder)->with("psychosocial_support", $psychosocialSupport);
        }
    }

    // GET MEDICAL VISIT DATA FOR BENEFITER
    public function getMedicalFolder(){
        $ExamResultsLookup = medical_examination_results_lookup::get()->all();
        return view('benefiter.medical-folder', compact('ExamResultsLookup'))->with('benefiter', new Benefiter());
    }
    // POST MEDICAL VISIT DATA
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
