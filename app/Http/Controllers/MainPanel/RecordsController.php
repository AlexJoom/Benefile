<?php

namespace App\Http\Controllers\MainPanel;

//models used
use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals;

// services used
use App\Services\BenefitersService;
use App\Services\Utilities\GeneralUseService;
use App\Services\BasicInfoService;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class RecordsController extends Controller
{
    // services
    private $basicInfoService;
    private $generalUseService;
    private $benefiterList = null;

    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
        // initialize benefiters list service
        $this->benefiterList = new BenefitersService();
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize general use service
        $this->generalUseService = new GeneralUseService();

    }

    //------------ GET BENEFITERS LIST -------------------------------//
    public function getBenefitersList(){
        $benefiters =  $this->benefiterList->getAllBenefiters();
        return view('benefiter.benefiters_list', compact('benefiters'));
    }

    // get basic info view
    public function getBasicInfo($id){
        // brings the referrals options array from db to view
        $basic_info_referral = $this->basicInfoService->get_basic_info_referrals_from_lookup();
        $basic_info_referral_attributes = $this->basicInfoService->get_basic_info_referral();

        $basic_info_referral_array = $this->generalUseService->reindex_array($basic_info_referral);
        // brinks all referrals saved to db for this benefiter id
        $benefiter_referrals_list = $this->basicInfoService->get_referrals_for_a_benefiter($id);
        $workTitle = null;
        $languages = $this->basicInfoService->getAllLanguages();
        $languageLevels = $this->basicInfoService->getAllLanguageLevels();
        // get legal statuses from session, else get null and afterwards forget session value
        // If validation fails, get back all previously written info
        $legal_statuses = session()->get('legalStatuses', function() { return null; });
        session()->forget('legalStatuses');
        $benefiterLanguagesAndLevels = session()->get('benefiter_languages', function() { return null; });
        session()->forget('benefiter_languages');
        $successMsg = session()->get('success', function() { return null; });
        session()->forget('success');
        $errors = session()->get('errors' , function() { return null; });
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
        }
        return view('benefiter.basic_info')->with("languages", $languages)
                                           ->with("languageLevels", $languageLevels)
                                           ->with("benefiter", $benefiter)
                                           ->with("legalStatuses", $legal_statuses)
                                           ->with("benefiter_languages", $benefiterLanguagesAndLevels)
                                           ->with('basic_info_referral_array', $basic_info_referral_array)
                                           ->with('benefiter_referrals_list', $benefiter_referrals_list)
                                           ->with('workTitle', $workTitle)
                                           ->with('success', $successMsg);
    }

    // post from basic info form
    public function postBasicInfo(Request $request, $id){
        $validator = $this->basicInfoService->basicInfoValidation($request->all(), $id);
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
                            'interpreter' => $request->interpreter,
                            'working' => $request->working,
                            'working_title' => $request->working_title,
                            'working_legally' => $request->working_legally,
                            'country_abandon_reason' => $request->country_abandon_reason,
                            'travel_route' => $request->travel_route,
                            'travel_duration' => $request->travel_duration,
                            'detention_duration' => $request->detention_duration,
                            'social_history' => $request->social_history,
                        ))
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

    // delete a benefiter from id
    public function getDeleteBenefiter($id){
        $this->basicInfoService->deleteBenefiter($id);
        return redirect('benefiters-list');
    }
}
