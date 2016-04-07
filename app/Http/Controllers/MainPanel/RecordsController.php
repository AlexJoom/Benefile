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
use App\Models\Benefiters_Tables_Models\medical_chronic_conditions;
use App\Models\Benefiters_Tables_Models\medical_examinations;
use App\Models\Benefiters_Tables_Models\medical_examination_results;
use App\Models\Benefiters_Tables_Models\medical_laboratory_results;
use App\Models\Benefiters_Tables_Models\medical_medication;
use App\Models\Benefiters_Tables_Models\medical_referrals;
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
    private $datesHelper;
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

        $this->datesHelper = new \app\Services\DatesHelper();
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
        $countryAbandonReasons = $this->basicInfoService->getAllCountryAbandonReasons();
        $basic_info_referral_array = $this->medicalVisit->reindex_array($basic_info_referral);
        // brings all referrals saved to db for this benefiter id
        $benefiter_referrals_list = $this->basicInfoService->get_referrals_for_a_benefiter($id);
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

    // get social folder view
    public function getSocialFolder($id){
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $psychologist_id = Auth::user()->id;
        // get psychosocial theme from session, else get null and afterwards forget session value
        $session_theme = session()->get('psychosocialTheme', function() { return null; });
        session()->forget('psychosocialTheme');
        $successMsg = session()->get('success', function() { return null; });
        session()->forget('success');
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
                    ->with('benefiter_sessions', $benefiter_sessions)
                    ->with('success', $successMsg);
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
            return redirect('benefiter/' . $id . '/social-folder')->with("tab", "social")->with("psychosocialSubjects", $psychosocialSubjects)->with("benefiter", $benefiter)->with("social_folder", $socialFolder)->with("psychosocial_support", $psychosocialSupport)->withErrors($validator->errors()->all());
        } else {
            $this->socialFolderService->saveSocialFolderToDB($request->all(), $id);
            $socialFolder = $this->socialFolderService->getSocialFolderFromBenefiterId($id);
            $psychosocialSupport = $this->socialFolderService->getBenefiterPsychosocialSupport($id);
            return redirect('benefiter/' . $id . '/social-folder')->with("tab", "social")->with("psychosocialSubjects", $psychosocialSubjects)->with("benefiter", $benefiter)->with("social_folder", $socialFolder)->with("psychosocial_support", $psychosocialSupport)->with('success', \Lang::get('records_controller_messages.social_folder_create_success'));
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
                ->withErrors($validator->errors()->all());
        } else {
            $this->socialFolderService->saveNewSessionToDB($request->all(), $id);
            return redirect('benefiter/'.$id.'/social-folder')->with('success', \Lang::get('records_controller_messages.session_create_success'));
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
                ->withErrors($validator->errors()->all());
        } else {
            $this->socialFolderService->saveEditedSessionToDB($request->all(), $session_id);
            return redirect('benefiter/'.$id.'/social-folder')->with('success', \Lang::get('records_controller_messages.session_edit_success'));
        }
    }

    // delete a session
    public function getSessionDelete($id, $session_id){
        $this->socialFolderService->deleteSessionById($session_id);
        return redirect("benefiter/" . $id . "/social-folder")->with('success', \Lang::get('records_controller_messages.session_delete_success'));
    }

//---------------------------- MEDICAL FOLDER -----------------------------------------------------//
//-------------------------------------------------------------------------------------------------//

    //------------ GET MEDICAL FOLDER FOR BENEFITER -------------------------------//
    public function getMedicalFolder($id){
        // POST result message
        $selected_medical_visit_id = session()->get('selected_medical_visit_id', function() { return 0; });
        $visit_submited_succesfully = session()->get('visit_submited_succesfully', function() { return 0; });
        session()->forget('visit_submited_succesfully'); // 0:initial value, 1:Success, 2:Unsuccess

        // ------ VALIDATION FAILURE SAVE TYPED DATA ------------------ //
            // chronic conditions
        $chronic_conditions_sesssion = session()->get('chronic_conditions_session');
        session()->forget('chronic_conditions_session');
            // lab results
        $lab_results_session = session()->get('lab_results_session');
        session()->forget('lab_results_session');
            // diagnosis results
        $diagnosis_results_session = session()->get('diagnosis_results_session');
        session()->forget('diagnosis_results_session');
            // hospitalizations
        $hospitalization_session = session()->get('hospitalization_session');
        session()->forget('hospitalization_session');
            // hospitalization dates
        $hospitalization_date_session = session()->get('hospitalization_date_session');
        session()->forget('hospitalization_date_session');
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
        $upload_file_description_session = session()->get('upload_file_description_session');
        session()->forget('upload_file_description_session');
        $upload_file_title_session = session()->get('upload_file_title_session');
        session()->forget('upload_file_title_session');

        // ------ END VALIDATION FAILURE SAVE TYPED DATA ------------------ //


        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $medical_visits_number = $this->medicalVisit->benefiter_medical_visits_number($id) ; //medical_visits::where('benefiter_id', $id)->count();
        $benefiter_medical_visits_list = $this->medicalVisit->findMedicalVisitsForBenefiter($id); // medical_visits::where('benefiter_id', $id)->with('doctor', 'medicalLocation', 'medicalIncidentType')->get();
        if ($benefiter == null) {
            return view('errors.404');
        } else {
            $ExamResultsLookup = $this->medicalVisit->examinationsResultsLookup(); //medical_examination_results_lookup::get()->all();
            // brings the medical location array from db
            $medical_locations = $this->medicalVisit->medicalLocationsLookup();  //medical_location_lookup::get();
            $medical_incident_type = $this->medicalVisit->medicalIncidentTypeLookup();  //medical_incident_type_lookup::get();
            $medical_locations_array = $this->medicalVisit->reindex_array($medical_locations);
            // If logged in user is admin then more medical locations can be added dynamically.
            if(Auth::user()->user_role_id == 1){
                $medical_locations_array['new_location'] = trans('partials/forms/new_medical_visit_form.' . 'new_exam_location' );
            }
            $medical_incident_type_array = $this->medicalVisit->reindex_array($medical_incident_type);
            $doctor_id = $this->medicalVisit->findDoctorId();  //Auth::user()->id;
            $benefiter_id = $benefiter->id;
            return view('benefiter.medical-folder')
                        ->with('selected_medical_visit_id', $selected_medical_visit_id)
                        ->with('ExamResultsLookup', $ExamResultsLookup)
                        ->with('medical_locations_array', $medical_locations_array)
                        ->with('medical_incident_type_array', $medical_incident_type_array)
                        ->with('benefiter_id', $benefiter_id)
                        ->with('doctor_id', $doctor_id)
                        ->with('benefiter', $benefiter)
                        ->with('medical_visits_number', $medical_visits_number)
                        ->with('chronic_conditions_sesssion', $chronic_conditions_sesssion)
                        ->with('lab_results_session', $lab_results_session)
                        ->with('diagnosis_results_session', $diagnosis_results_session)
                        ->with('hospitalization_session', $hospitalization_session)
                        ->with('hospitalization_date_session', $hospitalization_date_session)
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
                        ->with('benefiter_medical_visits_list', $benefiter_medical_visits_list)
                        ->with('upload_file_description_session', $upload_file_description_session)
                        ->with('upload_file_title_session', $upload_file_title_session)
                        ->with('visit_submited_succesfully', $visit_submited_succesfully);
        }
    }

    //------------ POST MEDICAL VISIT DATA ----------------------------------------//
    public function postMedicalFolder(Request $request, $id){
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $benefiter_folder_number = $this->medicalVisit->find_benefiter_folder_number($id);
        $benefiter_medical_history_list = $this->medicalVisit->get_all_medical_visits_for_benefiter($id);
        $doctor_id = $this->medicalVisit->get_logged_in_user_id();

        $benefiter_id = $benefiter->id;
        $medical_visits_number = $this->medicalVisit->count_medical_visits_for_a_benefiter($id);
        // brings the medical location array from db
        $medical_locations = $this->medicalVisit->getAllMedicalLocations();
        $medical_locations_array = $this->medicalVisit->reindex_array($medical_locations);
        $ExamResultsLookup = $this->medicalVisit->examinationsResultsLookup();

        // Post Validation
        $validator = $this->medicalVisit->medicalValidation($request->all());
        if($validator->fails()){
            //Fetch all array posts (if validation fails)
            $new_medical_location = $request['new_medical_location'];
            $chronic_conditions_session = $request['chronic_conditions'];
            $lab_results_session = $request['lab_results'];
            $diagnosis_results_session = $request['diagnosis_results'];
            $hospitalization_session = $request['hospitalization'];
            $hospitalization_date_session = $request['hospitalization_date'];
            $referrals_session = $request['referrals'];
            $examResultDescription_session = $request['examResultDescription'];
            $examResultLoukup_session = $request['examResultLoukup'];
            $medication_name_from_lookup_session = $request['medication_name_from_lookup'];
            $medication_new_name_session = $request['medication_new_name'];
            $medication_dosage_session = $request['medication_dosage'];
            $medication_duration_session = $request['medication_duration'];
            $supply_from_praksis_hidden_session = $request['supply_from_praksis_hidden'];

            $upload_file_description_session = $request['upload_file_description'];

            $upload_file_title_session = array();
            $upload_file_title_session_files = $request['upload_file_title'];
            if(!empty($upload_file_title_session_files)) {
                foreach ($upload_file_title_session_files as $uft) {
                    if(!empty($uft)) {
                        array_push($upload_file_title_session, $uft->getClientOriginalName());
                    }
                }
            }
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
                ->with('new_medical_location', $new_medical_location)
                ->with('ExamResultsLookup', $ExamResultsLookup)
                ->with('medical_visits_number', $medical_visits_number)
                ->with('visit_submited_succesfully', $visit_submited_succesfully)
                ->with('chronic_conditions_session', $chronic_conditions_session)
                ->with('lab_results_session', $lab_results_session)
                ->with('diagnosis_results_session', $diagnosis_results_session)
                ->with('hospitalization_session', $hospitalization_session)
                ->with('hospitalization_date_session', $hospitalization_date_session)
                ->with('referrals_session', $referrals_session)
                ->with('examResultDescription_session', $examResultDescription_session)
                ->with('examResultLoukup_session', $examResultLoukup_session)
                ->with('medication_name_from_lookup_session', $medication_name_from_lookup_session)
                ->with('medication_new_name_session', $medication_new_name_session)
                ->with('medication_dosage_session', $medication_dosage_session)
                ->with('medication_duration_session', $medication_duration_session)
                ->with('supply_from_praksis_hidden_session', $supply_from_praksis_hidden_session)
                ->with('upload_file_description_session', $upload_file_description_session)
                ->with('upload_file_title_session', $upload_file_title_session)
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

    //------------ GET MEDICAL VISIT MODAL DATA FOR BENEFITER FOR EACH VISIT ------//
    public function getMedicalVisitModal(Request $request, $id){
        // ------ MODAL: MEDICAL HISTORY DATA FOR EACH MEDICAL VISIT ------ //
        // initialize
        $med_visit_doctor = '';
        $med_visit_date = '';
        $med_visit_location = '';
        $med_visit_incident_type = '';
        $med_visit_chronic_conditions = '';
        $med_visit_height = '';
        $med_visit_weight = '';
        $med_visit_temperature = '';
        $med_visit_blood_pressure_systolic = '';
        $med_visit_blood_pressure_diastolic = '';
        $med_visit_skull_perimeter = '';
        $med_visit_exam_results = '';
        $med_visit_lab_results = '';
        $med_visit_diagnosis_results = '';
        $med_visit_medication = '';
        $med_visit_hospitalizations = '';
        $med_visit_referrals = '';
        $med_visit_uploads = '';
        // TODO CREATE A SERVICE THAT RETURNS A JSON WITH ALL INFO FOR EVERY VISIT
        $current_benefiter_medical_visit_id = $request['current_medical_visit'];
        $benefiter_medical_visits_list = $this->medicalVisit->findMedicalVisitsForBenefiter($id);
        $benefiter_folder_number = $this->medicalVisit->find_benefiter_folder_number($id);
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $ExamResultsLookup = $this->medicalVisit->get_medical_examination_results_from_lookup();
        // for every medical visit of the benefiter fetch the corresponding medical data from DB
        foreach($benefiter_medical_visits_list as $med_visit) {
            if ($med_visit['id'] == $current_benefiter_medical_visit_id) {
                //Doctor Name
                $med_visit_doctor = $med_visit['doctor']['name'] . ' ' . $med_visit['doctor']['lastname'];
                // Examination date
                if ($med_visit['medical_visit_date'] == null) {
                    $med_visit_date = $this->datesHelper->getFinelyFormattedStringDateFromDBDate($med_visit['created_at']);
                } else {
                    $med_visit_date = $this->datesHelper->getFinelyFormattedStringDateFromDBDate($med_visit['medical_visit_date']);
                }
                // Visit location
                $med_visit_location = $med_visit['medicalLocation']['description'];
                // Visit incident type
                $med_visit_incident_type = $med_visit['medicalIncidentType']['description'];
                // Chronic Conditions
                $med_visit_chronic_conditions = $this->medicalVisit->findMedicalChronicConditionsForBenefiter($id, $med_visit['id']);
                // physical examinations
                $med_visit_examination = $this->medicalVisit->findMedicalVisitExamination($med_visit['id']);
                // height
                $med_visit_height = $med_visit_examination['height'];
                // weight
                $med_visit_weight = $med_visit_examination['weight'];
                // temperature
                $med_visit_temperature = $med_visit_examination['temperature'];
                // blood pressure
                $med_visit_blood_pressure_systolic = $med_visit_examination['blood_pressure_systolic'];
                $med_visit_blood_pressure_diastolic = $med_visit_examination['blood_pressure_diastolic'];
                // skull_perimeter
                $med_visit_skull_perimeter = $med_visit_examination['skull_perimeter'];
                // Examination results
                $med_visit_exam_results = $this->medicalVisit->findMedicalVisitExaminationResults($med_visit['id']);
                // Lab results
                $med_visit_lab_results = $this->medicalVisit->findMedicalVisitLabResults($med_visit['id']);
                // Diagnosis results
                $med_visit_diagnosis_results = $this->medicalVisit->findMedicalVisitDiagnosisResults($med_visit['id']);
                // Medication
                $med_visit_medication = $this->medicalVisit->findMedicalVisitMedication($med_visit['id']);
                // Hospitalizations
                $med_visit_hospitalizations = $this->medicalVisit->findMedicalVisitHospitalizations($med_visit['id']);
                // Referrals
                $med_visit_referrals = $this->medicalVisit->findMedicalVisitReferrals($med_visit['id']);
                // Uploads
                $med_visit_uploads = $this->medicalVisit->findMedicalVisitUploads($med_visit['id']);
            }
        }
        // ------ END MODAL: MEDICAL HISTORY DATA FOR EACH MEDICAL VISIT ------ //
        return  view('partials.modals.medical_visit_info')
                                                    ->with('benefiter_medical_visits_list', $benefiter_medical_visits_list)
                                                    ->with('med_visit_doctor', $med_visit_doctor)
                                                    ->with('med_visit_location', $med_visit_location)
                                                    ->with('med_visit_incident_type', $med_visit_incident_type)
                                                    ->with('med_visit_chronic_conditions', $med_visit_chronic_conditions)
                                                    ->with('med_visit_height', $med_visit_height)
                                                    ->with('med_visit_weight', $med_visit_weight)
                                                    ->with('med_visit_temperature', $med_visit_temperature)
                                                    ->with('med_visit_blood_pressure_systolic', $med_visit_blood_pressure_systolic)
                                                    ->with('med_visit_blood_pressure_diastolic', $med_visit_blood_pressure_diastolic)
                                                    ->with('med_visit_skull_perimeter', $med_visit_skull_perimeter)
                                                    ->with('med_visit_exam_results', $med_visit_exam_results)
                                                    ->with('med_visit_lab_results', $med_visit_lab_results)
                                                    ->with('med_visit_diagnosis_results', $med_visit_diagnosis_results)
                                                    ->with('med_visit_medication', $med_visit_medication)
                                                    ->with('med_visit_hospitalizations', $med_visit_hospitalizations)
                                                    ->with('med_visit_referrals', $med_visit_referrals)
                                                    ->with('med_visit_uploads', $med_visit_uploads)
                                                    ->with('benefiter_folder_number', $benefiter_folder_number)
                                                    ->with('benefiter', $benefiter)
                                                    ->with('ExamResultsLookup', $ExamResultsLookup)
                                                    ->with('med_visit_date', $med_visit_date);
    }

    //------------ GET: EDIT MEDICAL VISIT ----------------------------------------//
    public function getMedicalVisitForEditing(Request $request, $id){
        $selected_medical_visit_id = $request['medical_visit_id'];
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $benefiter_medical_visits_list = $this->medicalVisit->findMedicalVisitsForBenefiter($id);
//        $doctor_id = $this->medicalVisit->findDoctorId();
        $medical_locations = $this->medicalVisit->medicalLocationsLookup();  //medical_location_lookup::get();
        $medical_incident_type = $this->medicalVisit->medicalIncidentTypeLookup();  //medical_incident_type_lookup::get();
        $medical_locations_array = $this->medicalVisit->reindex_array($medical_locations);
        // If logged in user is admin then more medical locations can be added dynamically.
        if(Auth::user()->user_role_id == 1){
            $medical_locations_array['new_location'] = trans('partials/forms/new_medical_visit_form.' . 'new_exam_location' );
        }
        $medical_incident_type_array = $this->medicalVisit->reindex_array($medical_incident_type);
        $ExamResultsLookup = $this->medicalVisit->examinationsResultsLookup();

        // initialize variables
        $med_visit_doctor = '';
        $med_visit_date = '';
        $med_visit_location_id = '';
        $med_visit_incident_type_id = '';
        $med_visit_chronic_conditions = '';
        $med_visit_height = '';
        $med_visit_weight = '';
        $med_visit_temperature = '';
        $med_visit_blood_pressure_systolic = '';
        $med_visit_blood_pressure_diastolic = '';
        $med_visit_skull_perimeter = '';
        $med_visit_exam_results = '';
        $med_visit_lab_results = '';
        $med_visit_diagnosis_results = '';
        $med_visit_medication = '';
        $med_visit_hospitalizations = '';
        $med_visit_referrals = '';

        // for every medical visit of the benefiter fetch the corresponding medical data from DB
        foreach($benefiter_medical_visits_list as $med_visit) {
            if ($med_visit['id'] == $selected_medical_visit_id) {
                $doctor_id = $med_visit['doctor']['id'];
                //Doctor Name
                $med_visit_doctor = $med_visit['doctor']['name'] . ' ' . $med_visit['doctor']['lastname'];
                // Examination date
                if ($med_visit['medical_visit_date'] == null) {
                    $med_visit_date = $this->datesHelper->getFinelyFormattedStringDateFromDBDate($med_visit['created_at']);
                } else {
                    $med_visit_date = $this->datesHelper->getFinelyFormattedStringDateFromDBDate($med_visit['medical_visit_date']);
                }
                // Visit location
                $med_visit_location_id = $med_visit['medical_location_id'];
                // Visit incident type
                $med_visit_incident_type_id = $med_visit['medical_incident_id'];
                // Chronic Conditions
                $med_visit_chronic_conditions = $this->medicalVisit->findMedicalChronicConditionsForBenefiter($id, $med_visit['id']);
                // physical examinations
                $med_visit_examination = $this->medicalVisit->findMedicalVisitExamination($med_visit['id']);
                // height
                $med_visit_height = $med_visit_examination['height'];
                // weight
                $med_visit_weight = $med_visit_examination['weight'];
                // temperature
                $med_visit_temperature = $med_visit_examination['temperature'];
                // blood pressure
                $med_visit_blood_pressure_systolic = $med_visit_examination['blood_pressure_systolic'];
                $med_visit_blood_pressure_diastolic = $med_visit_examination['blood_pressure_diastolic'];
                // skull_perimeter
                $med_visit_skull_perimeter = $med_visit_examination['skull_perimeter'];
                // Examination results
                $med_visit_exam_results = $this->medicalVisit->findMedicalVisitExaminationResults($med_visit['id']);
                // Lab results
                $med_visit_lab_results = $this->medicalVisit->findMedicalVisitLabResults($med_visit['id']);
                // Diagnosis results
                $med_visit_diagnosis_results = $this->medicalVisit->findMedicalVisitDiagnosisResults($med_visit['id']);
                // Medication
                $med_visit_medication = $this->medicalVisit->findMedicalVisitMedication($med_visit['id']);
                // Hospitalizations
                $med_visit_hospitalizations = $this->medicalVisit->findMedicalVisitHospitalizations($med_visit['id']);
                // Referrals
                $med_visit_referrals = $this->medicalVisit->findMedicalVisitReferrals($med_visit['id']);
                // Uploads
                $med_visit_uploads = $this->medicalVisit->findMedicalVisitUploads($med_visit['id']);

//                dd($med_visit_uploads[0]['title']);
            }
        }
        return view('partials.forms.medical-visit.medical_visit_edit')
            ->with('selected_medical_visit_id',$selected_medical_visit_id)
            ->with('benefiter',$benefiter)
            ->with('doctor_id',$doctor_id)
            ->with('med_visit_date',$med_visit_date)
            ->with('med_visit_location_id',$med_visit_location_id)
            ->with('med_visit_incident_type_id',$med_visit_incident_type_id)
            ->with('med_visit_chronic_conditions',$med_visit_chronic_conditions)
            ->with('med_visit_height',$med_visit_height)
            ->with('med_visit_weight',$med_visit_weight)
            ->with('med_visit_temperature',$med_visit_temperature)
            ->with('med_visit_blood_pressure_systolic',$med_visit_blood_pressure_systolic)
            ->with('med_visit_blood_pressure_diastolic',$med_visit_blood_pressure_diastolic)
            ->with('med_visit_skull_perimeter',$med_visit_skull_perimeter)
            ->with('med_visit_exam_results',$med_visit_exam_results)
            ->with('med_visit_lab_results',$med_visit_lab_results)
            ->with('med_visit_diagnosis_results',$med_visit_diagnosis_results)
            ->with('med_visit_medication',$med_visit_medication)
            ->with('med_visit_hospitalizations', $med_visit_hospitalizations)
            ->with('med_visit_referrals',$med_visit_referrals)
            ->with('med_visit_uploads',$med_visit_uploads)
            ->with('medical_locations_array',$medical_locations_array)
            ->with('medical_incident_type_array',$medical_incident_type_array)
            ->with('ExamResultsLookup',$ExamResultsLookup)
            ->with('med_visit_doctor',$med_visit_doctor)
            ->with('$benefiter_medical_visits_list', $benefiter_medical_visits_list);
    }

    //------------ POST: EDIT MEDICAL VISIT ---------------------------------------//
    public function postMedicalVisitFromEditing(Request $request){
        $selected_medical_visit_id = $request['selected_medical_visit_id'];
        $benefiter_id = $request['benefiter_id'];
//        dd($request->all());

        // Post Validation
        $validator = $this->medicalVisit->medicalValidation($request->all());
        if($validator->fails()){
            $visit_submited_succesfully = 2; // 0:initial value, 1:Success, 2:Unsuccess
            return redirect('benefiter/'.$benefiter_id.'/editMedicalVisit?medical_visit_id='.$selected_medical_visit_id)
                ->with('visit_submited_succesfully', $visit_submited_succesfully)
                ->withErrors($validator->errors()->all());
        } else {
            $this->medicalVisit->update_medical_visit_tables($request->all(), $selected_medical_visit_id);
            $visit_submited_succesfully = 3; // 0:initial value, 1:Success, 2:Unsuccess, 3: Success update
            return redirect('benefiter/'.$benefiter_id.'/medical-folder')
                ->with('selected_medical_visit_id', $selected_medical_visit_id)
                ->with('visit_submited_succesfully', $visit_submited_succesfully);
        }

    }

    //------ MEDICATION LIST FETCH "LIKE" OBJECTS ---------------------------------//
    public function getMedicationList(Request $request){
        $full_medication_name = $this->medicalVisit->get_full_medication_name($request['q']);
        return $full_medication_name;
    }

    //------ ICD10 SELECT LIST FETCH "LIKE" OBJECTS -------------------------------//
    public function getICD10List(Request $request){
        $full_icd10_description = $this->medicalVisit->get_full_icd10_description($request['q']);
        return $full_icd10_description;
    }

    // ------ MODAL: MEDICAL HISTORY DATA FOR EACH MEDICAL VISIT ----------------- //
    public function fetch_medical_visits_data(Request $request){
        $current_benefiter_medical_visit_id = $request['current_medical_visit'];
        return $current_benefiter_medical_visit_id;
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
        $successMsg = session()->get('success', function() { return null; });
        session()->forget('success');
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
            ->with('tab', 'legal')
            ->with('success', $successMsg);
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
            return redirect('benefiter/'.$id.'/legal-folder')->with('success', \Lang::get('records_controller_messages.legal_folder_create_success'));
        }
    }
}
