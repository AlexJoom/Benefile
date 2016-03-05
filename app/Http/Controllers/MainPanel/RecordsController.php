<?php

namespace App\Http\Controllers\MainPanel;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\medical_examination_results_lookup;
use App\Models\Benefiters_Tables_Models\medical_location_lookup;
use App\Models\Benefiters_Tables_Models\medical_incident_type_lookup;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals_lookup;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals;
use App\Models\Benefiters_Tables_Models\medical_visits;
use App\Models\Benefiters_Tables_Models\ICD10;
use App\Models\Benefiters_Tables_Models\medical_medication_lookup;
use App\Services\SocialFolderService;
use App\Services\BenefiterMedicalFolderService;
use App\Services\BenefitersService;
use App\Services\LegalFolderService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\BasicInfoService;
use Illuminate\Support\Facades\Auth;
use Validator;

class RecordsController extends Controller
{
    // services
    private $basicInfoService;
    private $socialFolderService;
    private $medicalVisit;
    private $legalFolderService;
    private $benefiterList = null;

    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
        // initialize benefiters list service
        $this->benefiterList = new BenefitersService();
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize social folder service
        $this->socialFolderService = new SocialFolderService();
        // initialize medical visit service
        $this->medicalVisit = new BenefiterMedicalFolderService();
        // initialize legal folder service
        $this->legalFolderService = new LegalFolderService();
    }

    //------------ GET BENEFITERS LIST -------------------------------//
    public function getBenefitersList(){
        $benefiters =  $this->benefiterList->getAllBenefiters();
        return view('benefiter.benefiters_list', compact('benefiters'));
    }

    // get basic info view
    public function getBasicInfo($id){
        // brings the referrals options array from db to view
        $basic_info_referral = BenefiterReferrals_lookup::get()->all();
        $basic_info_referral_array = $this->medicalVisit->reindex_array($basic_info_referral);
        // brinks all referrals saved to db for this benefiter id
        $benefiter_referrals_list = BenefiterReferrals::where('benefiter_id', $id)->with('referralType')
                                                        ->get();
        $languages = $this->basicInfoService->getAllLanguages();
        $languageLevels = $this->basicInfoService->getAllLanguageLevels();
        // get legal statuses from session, else get null and afterwards forget session value
        $legal_statuses = session()->get('legalStatuses', function() { return null; });
        session()->forget('legalStatuses');
        $benefiterLanguagesAndLevels = session()->get('benefiter_languages', function() { return null; });
        session()->forget('benefiter_languages');
        $successMsg = session()->get('success', function() { return null; });
        session()->forget('successMsg');
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
        $basic_info_referrals = BenefiterReferrals::get()->all();

        return redirect('benefiter/'.$request['benefiter_id'].'/basic-info')->with('basic_info_referrals',$basic_info_referrals);
    }

    // get social folder view
    public function getSocialFolder($id){
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $psychologist_id = Auth::user()->id;
        // get psychosocial theme from session, else get null and afterwards forget session value
        $session_theme = session()->get('psychosocialTheme', function() { return null; });
        session()->forget('psychosocialTheme');
        if($benefiter == null) {
            return view('errors.404');
        } else {
            $socialFolder = $this->socialFolderService->getSocialFolderFromBenefiterId($id);
            $psychosocialSubjects = $this->socialFolderService->getAllPsychosocialSupportSubjects();
            if($socialFolder == null){
                return view('benefiter.social_folder')
                    ->with("tab", "social")
                    ->with("psychosocialSubjects", $psychosocialSubjects)
                    ->with("benefiter", $benefiter)
                    ->with("psychologist_id", $psychologist_id);
            } else {
                $benefiter_sessions = $this->socialFolderService->getAllSessionsFromBenefiterId($id);
                $psychosocialSupport = $this->socialFolderService->getBenefiterPsychosocialSupport($id);
                return view('benefiter.social_folder')
                    ->with("tab", "social")
                    ->with("psychosocialSubjects", $psychosocialSubjects)
                    ->with("benefiter", $benefiter)
                    ->with("social_folder", $socialFolder)
                    ->with("psychosocial_support", $psychosocialSupport)
                    ->with("psychologist_id", $psychologist_id)
                    ->with("session_theme", $session_theme)
                    ->with('benefiter_sessions', $benefiter_sessions);
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

    // save a new session from social folder view
    public function postSessionSave(Request $request, $id){
        $validator = $this->socialFolderService->sessionValidation(array(
                                                                        'session_date' => $request->session_date,
                                                                        'session_comments' => $request->session_comments
                                                                     ));
        if($validator->fails()){
            return redirect('benefiter/'.$id.'/social-folder')
                ->withInput(array(
                                    'session_comments' => $request->session_comments,
                                    'session_date' => $request->session_date,
                                 ))
                ->with('psychosocialTheme', $request->psychosocial_theme)
                ->withFlashMessage($validator->errors()->all());
        } else {
            $this->socialFolderService->saveNewSessionToDB($request->all(), $id);
            return redirect('benefiter/'.$id.'/social-folder');
        }
    }

    // update an edited session
    public function postSessionEdit(Request $request, $id, $session_id){
        $validator = $this->socialFolderService->sessionValidation(array(
                                                                    'session_date' => $request->session_date,
                                                                    'session_comments' => $request->session_comments
                                                                  ));
        if($validator->fails()){
            return redirect('benefiter/'.$id.'/social-folder')
                ->withInput(array(
                    'session_comments' => $request->session_comments,
                    'session_date' => $request->session_date,
                ))
                ->with('psychosocialTheme', $request->psychosocial_theme)
                ->withFlashMessage($validator->errors()->all());
        } else {
            $this->socialFolderService->saveEditedSessionToDB($request->all(), $session_id);
            return redirect('benefiter/'.$id.'/social-folder');
        }
    }

    // delete a session
    public function getSessionDelete($id, $session_id){
        $this->socialFolderService->deleteSessionById($session_id);
        return redirect("benefiter/" . $id . "/social-folder");
    }

//-------------------------------------------------------------------------------------------------//
//---------------------------- MEDICAL FOLDER -----------------------------------------------------//

    //------------ GET MEDICAL VISIT DATA FOR BENEFITER -------------------------------//
    public function getMedicalFolder($id){
        $visit_submited_succesfully = session()->get('visit_submited_succesfully', function() { return 0; });
        session()->forget('visit_submited_succesfully'); // 0:initial value, 1:Success, 2:Unsuccess

        // ------ VALIDATION FAILURE SAVE TYPED DATA ------------------ //
            // chronic conditions
        $chronic_conditions_sesssion = session()->get('chronic_conditions_session');
        session()->forget('chronic_conditions_session');
            // lab results
        $lab_results_session = session()->get('lab_results_session');
        session()->forget('lab_results_session');
            // referrals
        $referrals_session = session()->get('referrals_session');
        session()->forget('referrals_session');
            //Examination results (consists of selected conditions & descriptions)
        $examResultDescription_session = session()->get('examResultDescription_session');
        session()->forget('examResultDescription_session');
        $examResultLoukup_session = session()->get('examResultLoukup_session');
        session()->forget('examResultLoukup_session');
            // transform the above session ICD10 ids into respective description
        $examResultLoukup_session_description =[[]];
        for($i=0 ; $i<count($examResultLoukup_session) ; $i++){
            for ($j=0 ; $j<count($examResultLoukup_session[$i]) ; $j++){
                if(!empty($examResultLoukup_session[$i][$j])){
                    $examResultLoukup_session_description[$i][$j] = $this->medicalVisit->getICD10By_id($examResultLoukup_session[$i][$j]);
                }
            }
        }
            // medication (consists of lookup select options or typed name, dosage, duration, supplied from PRAKSIS checkbox )
        $medication_name_from_lookup_session = session()->get('medication_name_from_lookup_session');
        session()->forget('medication_name_from_lookup_session');
        $medication_name_from_lookup_session_description = [];
        for($i=0; $i<count($medication_name_from_lookup_session) ; $i++){
            $medication_name_from_lookup_session_description[$i] = $this->medicalVisit->getMedicationLookupBy_id($medication_name_from_lookup_session[$i]);
        }
        $medication_new_name_session = session()->get('medication_new_name_session');
        session()->forget('medication_new_name_session');
        $medication_dosage_session = session()->get('medication_dosage_session');
        session()->forget('medication_dosage_session');
        $medication_duration_session = session()->get('medication_duration_session');
        session()->forget('medication_duration_session');
        $supply_from_praksis_hidden_session = session()->get('supply_from_praksis_hidden_session');
        session()->forget('supply_from_praksis_hidden_session');
//        $upload_file_description_session = session()->get('upload_file_description_session');
//        session()->forget('upload_file_description_session');
//        $upload_file_title_session = session()->get('upload_file_title_session');
//        session()->forget('upload_file_title_session');
        // ------ END VALIDATION FAILURE SAVE TYPED DATA ------------------ //



        // ------ MODAL: MEDICAL HISTORY DATA FOR EACH MEDICAL VISIT ------ //
        $current_benefiter_medical_history_list = medical_visits::where('benefiter_id', $id)->with('doctor', 'medicalLocation')->get();


        // ------ MODAL: MEDICAL HISTORY DATA FOR EACH MEDICAL VISIT ------ //


        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $medical_visits_number = medical_visits::where('benefiter_id', $id)->count();
        if ($benefiter == null) {
            return view('errors.404');
        } else {
            $ExamResultsLookup = medical_examination_results_lookup::get()->all();
            // brings the medical location array from db
            $medical_locations = medical_location_lookup::get();
            $medical_incident_type = medical_incident_type_lookup::get();
            $medical_locations_array = $this->medicalVisit->reindex_array($medical_locations);
            $medical_incident_type_array = $this->medicalVisit->reindex_array($medical_incident_type);
            $benefiter_folder_number = Benefiter::where('id', '=', $id)->first()->folder_number;
            $doctor_id = Auth::user()->id;
            $benefiter_id = $benefiter->id;
            return view('benefiter.medical-folder')
                        ->with('ExamResultsLookup', $ExamResultsLookup)
                        ->with('medical_locations_array', $medical_locations_array)
                        ->with('medical_incident_type_array', $medical_incident_type_array)
                        ->with('benefiter_folder_number', $benefiter_folder_number)
                        ->with('benefiter_id', $benefiter_id)
                        ->with('doctor_id', $doctor_id)
                        ->with('benefiter', $benefiter)
                        ->with('current_benefiter_medical_history_list', $current_benefiter_medical_history_list)
                        ->with('medical_visits_number', $medical_visits_number)
                        ->with('chronic_conditions_sesssion', $chronic_conditions_sesssion)
                        ->with('lab_results_session', $lab_results_session)
                        ->with('referrals_session', $referrals_session)
                        ->with('examResultDescription_session', $examResultDescription_session)
                        ->with('examResultLoukup_session', $examResultLoukup_session)
                        ->with('examResultLoukup_session_description', $examResultLoukup_session_description)
                        ->with('medication_name_from_lookup_session', $medication_name_from_lookup_session)
                        ->with('medication_name_from_lookup_session_description', $medication_name_from_lookup_session_description)
                        ->with('medication_new_name_session', $medication_new_name_session)
                        ->with('medication_dosage_session', $medication_dosage_session)
                        ->with('medication_duration_session', $medication_duration_session)
                        ->with('supply_from_praksis_hidden_session', $supply_from_praksis_hidden_session)
//                        ->with('upload_file_description_session', $upload_file_description_session)
//                        ->with('upload_file_title_session', $upload_file_title_session)
                        ->with('visit_submited_succesfully', $visit_submited_succesfully);
        }
    }

    //------------ POST MEDICAL VISIT DATA -------------------------------//
    public function postMedicalFolder(Request $request, $id){
//        dd($request->all());
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $benefiter_folder_number = Benefiter::where('id', '=', $id)->first()->folder_number;
        $benefiter_medical_history_list = medical_visits::where('benefiter_id', $id)->with('doctor', 'medicalLocation')->get();
        $doctor_id = Auth::user()->id;

        $benefiter_id = $benefiter->id;
        $medical_visits_number = medical_visits::where('benefiter_id', $id)->count();
        // brings the medical location array from db
        $medical_locations = medical_location_lookup::get()->all();
        $medical_locations_array = $this->medicalVisit->reindex_array($medical_locations);
        $ExamResultsLookup = medical_examination_results_lookup::get()->all();

        // Post Validation
        $validator = $this->medicalVisit->medicalValidation($request->all());
        if($validator->fails()){
            //Fetch all array posts (if validation fails)
            $chronic_conditions_session = $request['chronic_conditions'];
            $lab_results_session = $request['lab_results'];
            $referrals_session = $request['referrals'];
            $examResultDescription_session = $request['examResultDescription'];
            $examResultLoukup_session = $request['examResultLoukup'];
            $medication_name_from_lookup_session = $request['medication_name_from_lookup'];
            $medication_new_name_session = $request['medication_new_name'];
            $medication_dosage_session = $request['medication_dosage'];
            $medication_duration_session = $request['medication_duration'];
            $supply_from_praksis_hidden_session = $request['supply_from_praksis_hidden'];

//            $upload_file_description_session = $request['upload_file_description'];
//            $upload_file_title_session = $request['upload_file_title'];


            $visit_submited_succesfully = 2; // 0:initial value, 1:Success, 2:Unsuccess
            return redirect('benefiter/'.$benefiter_id.'/medical-folder')
                ->withInput(array(
                    'examination_date' => $request['examination_date'],
                    'medical_location_id' => $request['medical_location_id'],
                    'incident_type' => $request['incident_type'],
                    'height' => $request['height'],
                    'weight' => $request['weight'],
                    'temperature' => $request['temperature'],
                    'blood_pressure_systolic' => $request['blood_pressure_systolic'],
                    'blood_pressure_diastolic' => $request['blood_pressure_diastolic'],
                    'skull_perimeter' => $request['skull_perimeter'],
                ))
                // ALL THE BELLOW ARE SEND BACK TO THE FORM IF THE POST FAIL
                ->with('benefiter', $benefiter)
                ->with('benefiter_folder_number', $benefiter_folder_number)
                ->with('benefiter_medical_history_list', $benefiter_medical_history_list)
                ->with('doctor_id', $doctor_id)
                ->with('benefiter_id', $benefiter_id)
                ->with('medical_locations_array', $medical_locations_array)
                ->with('ExamResultsLookup', $ExamResultsLookup)
                ->with('medical_visits_number', $medical_visits_number)
                ->with('visit_submited_succesfully', $visit_submited_succesfully)
                ->with('chronic_conditions_session', $chronic_conditions_session)
                ->with('lab_results_session', $lab_results_session)
                ->with('referrals_session', $referrals_session)
                ->with('examResultDescription_session', $examResultDescription_session)
                ->with('examResultLoukup_session', $examResultLoukup_session)
                ->with('medication_name_from_lookup_session', $medication_name_from_lookup_session)
                ->with('medication_new_name_session', $medication_new_name_session)
                ->with('medication_dosage_session', $medication_dosage_session)
                ->with('medication_duration_session', $medication_duration_session)
                ->with('supply_from_praksis_hidden_session', $supply_from_praksis_hidden_session)
//                ->with('upload_file_description_session', $upload_file_description_session)
//                ->with('upload_file_title_session', $upload_file_title_session)
                ->withErrors($validator->errors()->all());
        } else {
            $this->medicalVisit->save_new_medical_visit_tables($request->all());
            $visit_submited_succesfully = 1; // 0:initial value, 1:Success, 2:Unsuccess
            return redirect('benefiter/'.$benefiter_id.'/medical-folder')
                ->with('benefiter', $benefiter)
                ->with('benefiter_folder_number', $benefiter_folder_number)
                ->with('benefiter_medical_history_list', $benefiter_medical_history_list)
                ->with('doctor_id', $doctor_id)
                ->with('benefiter_id', $benefiter_id)
                ->with('medical_locations_array', $medical_locations_array)
                ->with('ExamResultsLookup', $ExamResultsLookup)
                ->with('medical_visits_number', $medical_visits_number)
//                ->with('icd10', $icd10)
                ->with('visit_submited_succesfully', $visit_submited_succesfully);
        }

    }

    //------ MEDICATION LIST FETCH "LIKE" OBJECTS --------------------//
    public function getMedicationList(Request $request){
        return medical_medication_lookup::where('description','LIKE', '%'.$request['m'].'%' )->get();
    }

    //------ ICD10 SELECT LIST FETCH "LIKE" OBJECTS --------------------//
    public function getICD10List(Request $request){
        return ICD10::where('description','LIKE', '%'.$request['q'].'%' )->get();
    }

    // ------ MODAL: MEDICAL HISTORY DATA FOR EACH MEDICAL VISIT ------ //
    public function fetch_medical_visits_data($id){
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $current_benefiter_medical_history_list = medical_visits::where('benefiter_id', $id)->with('doctor', 'medicalLocation')->get();
        return $current_benefiter_medical_history_list;
    }

//-------------------------------------------------------------------------------------------------//
//---------------------------- END MEDICAL FOLDER -------------------------------------------------//


    // delete a benefiter from id
    public function getDeleteBenefiter($id){
        $this->basicInfoService->deleteBenefiter($id);
        return redirect('benefiters-list');
    }

    // returns view of legal folder
    public function getLegalFolder($id){
        $legalFolder = $this->legalFolderService->findLegalFolderFromBenefiterId($id);
        $asylumRequest = null;
        $noLegalStatus = null;
        $lawyerActions = null;
        // if the legal folder exists return all things connected with it
        if($legalFolder != null){
            $asylumRequest = $this->legalFolderService->findAsylumRequestFromLegalFolderId($legalFolder->id);
            $noLegalStatus = $this->legalFolderService->findNoLegalStatusFromLegalFolderId($legalFolder->id);
            $lawyerActions = $this->legalFolderService->findLawyerActionsFromLegalFolderId($legalFolder->id);
        }
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        if($benefiter == null){
            return view('errors.404');
        }
        return view('benefiter.legal_folder')
            ->with('legal_folder', $legalFolder)
            ->with('benefiter', $benefiter)
            ->with('asylum_request', $asylumRequest)
            ->with('no_legal_status', $noLegalStatus)
            ->with('lawyer_action', $lawyerActions)
            ->with('tab', 'legal');
    }

    // gets data from legal folder form
    public function postLegalFolder(Request $request, $id){
        $validator = $this->legalFolderService->legalFolderValidator($request->all());
        if ($validator->fails()){
            return redirect('benefiter/'.$id.'/legal-folder')
                ->withInput($request->all())
                ->withErrors($validator->errors()->all());
        } else {
            $this->legalFolderService->saveLegalFolderToDB($request->all(), $id);
            return redirect('benefiter/'.$id.'/legal-folder');
        }
    }
}
