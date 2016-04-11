<?php

namespace App\Http\Controllers\Basic_Info_Folder;

//models used
use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals;

// services used
use App\Services\Utilities\GeneralUseService;
use App\Services\Basic_info_folder\BasicInfoService;
use App\Services\Validation_services\Basic_info_folder\BasicInfoValdationService;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class BasicInfoController extends Controller{
    private $basicInfoService;
    private $generalUseService;
    private $basic_info_validation;

    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
        // initialize benefiter basic info validation
        $this->basic_info_validation = new BasicInfoValdationService();
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize general use service
        $this->generalUseService = new GeneralUseService();
    }

    // get basic info view
    public function getBasicInfo($id){
        // get all occurrences from DB
        $occurrences = $this->basicInfoService->getAllOccurrencesByBenefiter($id);
        // brings the referrals options array from db to view

        $basic_info_referral = $this->basicInfoService->get_basic_info_referrals_from_lookup();
        $countryAbandonReasons = $this->basicInfoService->getAllCountryAbandonReasons();
        $basic_info_referral_array = $this->generalUseService->reindex_array($basic_info_referral);
        // brings all referrals saved to db for this benefiter id
        $benefiter_referrals_list = $this->basicInfoService->get_basic_info_referral_by_id($id);
        $workTitle = null;
        $languages = $this->basicInfoService->getAllLanguages();
        $languageLevels = $this->basicInfoService->getAllLanguageLevels();
        // get legal statuses from session, else get null and afterwards forget session value
        // If validation fails, get back all previously written info
        $country_abandon_reason = session()->get('country_abandon_reason', function() { return 1; });
        session()->forget('country_abandon_reason');
        $legal_statuses = session()->get('legalStatuses', function() { return null; });
        session()->forget('legalStatuses');
        $benefiterLanguagesAndLevels = session()->get('benefiter_languages', function() { return null; });
        session()->forget('benefiter_languages');
        $successMsg = session()->get('success', function() { return null; });
        session()->forget('success');
        $errors = session()->get('errors' , function() { return null; });
        session()->forget('errors');
        // checks if id is correct, so it could find the existent benefiter with that id
        if($id > 0){
            $benefiter = $this->basicInfoService->findExistentBenefiter($id);
            if($benefiter == null) {
                return view('errors.404');
            } else {
                if ($errors == null) {
                    $legal_statuses = $this->basicInfoService->getLegalStatusesByBenefiterId($id);
                }
                $benefiterLanguagesAndLevels = $this->basicInfoService->getLanguagesAndLanguagesLevelsByBenefiterId($id);
                $workTitle = $this->basicInfoService->getWorkTitleNameFromBenefiterId($id);
            }
        } else {
            $benefiter = new Benefiter();
            $benefiter->country_abandon_reason_id = $country_abandon_reason;
        }
        return view('benefiter.basic_info')->with("languages", $languages)
            ->with("languageLevels", $languageLevels)
            ->with("occurrences", $occurrences)
            ->with("benefiter", $benefiter)
            ->with("legalStatuses", $legal_statuses)
            ->with("benefiter_languages", $benefiterLanguagesAndLevels)
            ->with('basic_info_referral_array', $basic_info_referral_array)
            ->with('benefiter_referrals_list', $benefiter_referrals_list)
            ->with('workTitle', $workTitle)
            ->with('success', $successMsg)
            ->with('countryAbandonReasons', $countryAbandonReasons);
    }

    // post from basic info form
    public function postBasicInfo(Request $request, $id){
        $validator = $this->basic_info_validation->basicInfoValidationService($request->all(), $id);
        if($validator->fails()){
            $legal_statuses = $this->basicInfoService->getLegalStatusesArrayFromRequest($request->legal_status, $request->legal_status_text, $request->legal_status_exp_date);
            $benefiterLanguagesAndLevels = $this->basicInfoService->getLanguagesAndLanguagesLevelsFromRequest($request->all());
            return redirect('benefiter/'.$id.'/basic-info')
                ->withInput(array(
                    'folder_number' => $request->folder_number,
                    'lastname' => $request->lastname,
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'birth_date' => $request->birth_date,
                    'fathers_name' => $request->fathers_name,
                    'mothers_name' => $request->mothers_name,
                    'nationality_country' => $request->nationality_country,
                    'origin_country' => $request->origin_country,
                    'arrival_date' => $request->arrival_date,
                    'ethnic_group' => $request->ethnic_group,
                    'telephone' => $request->telephone,
                    'address' => $request->address,
                    'marital_status' => $request->marital_status,
                    'number_of_children' => $request->number_of_children,
                    'relatives_residence' => $request->relatives_residence,
                    'children_names' => $request->children_names,
                    'education_status' => $request->education_status,
                    'education_specialization' => $request->education_specialization,
                    'interpreter' => $request->interpreter,
                    'working' => $request->working,
                    'working_title' => $request->working_title,
                    'working_legally' => $request->working_legally,
                    'travel_route' => $request->travel_route,
                    'travel_duration' => $request->travel_duration,
                    'detention_duration' => $request->detention_duration,
                    'social_history' => $request->social_history,
                ))
                ->with("country_abandon_reason", $request->country_abandon_reason)
                ->with("legalStatuses", $legal_statuses)
                ->with("benefiter_languages", $benefiterLanguagesAndLevels)
                ->withErrors($validator->errors()->all());
        } else {
            if($id > 0){
                $this->basicInfoService->editBasicInfo($request->all(), $id);
                $benefiter = new Benefiter();
                $benefiter->id = $id;
                $successMsg = \Lang::get('records_controller_messages.basic_info_edit_success');
            } else {
                $benefiter = $this->basicInfoService->saveBasicInfoToDB($request->all());
                $successMsg = \Lang::get('records_controller_messages.basic_info_create_success');
            }
            $legal_statuses = $this->basicInfoService->getLegalStatusesByBenefiterId($benefiter->id);
            $benefiterLanguagesAndLevels = $this->basicInfoService->getLanguagesAndLanguagesLevelsByBenefiterId($benefiter->id);
            return redirect('benefiter/'.$benefiter->id.'/basic-info')
                ->with("legalStatuses", $legal_statuses)
                ->with("benefiter_languages", $benefiterLanguagesAndLevels)
                ->with("success", $successMsg);
        }
    }

    // SAVE OCCURRENCES to DB with AJAX
    public function saveOccurrencesBasicInfo(Request $request, $id){
        // saves in DB, with the benefiter->id
        $this->basicInfoService->saveNewOccurrence($request);
        // Then return from the DB all occurrences history and return it to the view
        return redirect('benefiter/'.$id.'/basic-info');
    }

    // EDIT OCCURRENCE
    public function editOccurrencesBasicInfo(Request $request, $id, $occurrence_id){
        $this->basicInfoService->findOccurrence_by_id($request, $occurrence_id);
        return redirect('benefiter/'.$id.'/basic-info');
    }

    // DELETE OCCURRENCE
    public function deleteOccurrencesBasicInfo($id, $occurrence_id){
        $this->basicInfoService->deleteOccurrence_by_id($occurrence_id);
        return redirect('benefiter/'.$id.'/basic-info');
    }

    //------ POST BASIC INFO REFERRALS -------------------------------//
    public function postBasicInfoReferrals(Request $request){
        // update basic info referrals table
        $this->basicInfoService->basic_info_referrals($request);
        // fetch all saved referrals
        $basic_info_referrals = $this->basicInfoService->get_basic_info_referral();

        return redirect('benefiter/'.$request['benefiter_id'].'/basic-info')->with('basic_info_referrals',$basic_info_referrals)->with("success", \Lang::get('records_controller_messages.referrals_create_success'));
    }

    public function deleteBasicInfoReferral($id, $referral_id){
        BenefiterReferrals::where('id', '=', $referral_id)->delete();

        return redirect('benefiter/'.$id.'/basic-info')->with("success", \Lang::get('records_controller_messages.referrals_delete_success'));
    }
}
