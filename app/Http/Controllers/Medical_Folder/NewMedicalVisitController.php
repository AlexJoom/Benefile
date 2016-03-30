<?php

namespace App\Http\Controllers\Medical_Folder;

use App\Services\Medical_folder\BenefiterMedicalFolderService;
use App\Services\Medical_folder\BenefiterMedicalFolderDBdependentService;
use App\Services\Utilities\GeneralUseService;
use App\Services\Validation_services\Medical_folder\BenefiterMedicalFolderValidationService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewMedicalVisitController extends Controller{

    private $newMedicalVisit;
    private $db_dependences;
    private $general_use_services;
    private $new_medical_visit_validator;

    public function __construct(){
        // only for logged in users
        $this->middleware('activated');

        // initialize medical visit service
        $this->newMedicalVisit = new BenefiterMedicalFolderService();
        $this->db_dependences = new BenefiterMedicalFolderDBdependentService();
        $this->general_use_services = new GeneralUseService();
        $this->new_medical_visit_validator = new BenefiterMedicalFolderValidationService();
    }

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
                    $examResultLoukup_session_description[$i][$j] = $this->db_dependences->getICD10By_id($examResultLoukup_session[$i][$j]);
                }
            }
        }
        // medication (consists of lookup select options or typed name, dosage, duration, supplied from PRAKSIS checkbox )
        $medication_name_from_lookup_session = session()->get('medication_name_from_lookup_session');
        session()->forget('medication_name_from_lookup_session');
        $medication_name_from_lookup_session_description = [];
        for($i=0; $i<count($medication_name_from_lookup_session) ; $i++){
            $medication_name_from_lookup_session_description[$i] = $this->db_dependences->getMedicationLookupBy_id($medication_name_from_lookup_session[$i]);
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


        $benefiter = $this->db_dependences->find_benefiter_by_id($id);
        $medical_visits_number = $this->db_dependences->count_medical_visits_for_a_benefiter($id) ; //medical_visits::where('benefiter_id', $id)->count();
        $benefiter_medical_visits_list = $this->db_dependences->get_all_medical_visits_for_benefiter($id); // medical_visits::where('benefiter_id', $id)->with('doctor', 'medicalLocation', 'medicalIncidentType')->get();
        if ($benefiter == null) {
            return view('errors.404');
        } else {
            $ExamResultsLookup = $this->db_dependences->get_medical_examination_results_from_lookup(); //medical_examination_results_lookup::get()->all();
            // brings the medical location array from db
            $medical_locations = $this->db_dependences->get_all_medical_locations_lookup();  //medical_location_lookup::get();
            $medical_incident_type = $this->db_dependences->medical_incident_type_lookup();  //medical_incident_type_lookup::get();
            $medical_locations_array = $this->general_use_services->reindex_array($medical_locations);
            $medical_incident_type_array = $this->general_use_services->reindex_array($medical_incident_type);
            $doctor_id = $this->db_dependences->get_logged_in_user_id();  //Auth::user()->id;
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
//                        ->with('upload_file_description_session', $upload_file_description_session)
//                        ->with('upload_file_title_session', $upload_file_title_session)
                ->with('visit_submited_succesfully', $visit_submited_succesfully);
        }
    }

    //------------ POST MEDICAL VISIT DATA ----------------------------------------//
    public function postMedicalFolder(Request $request, $id){
        $benefiter = $this->db_dependences->find_benefiter_by_id($id);
        $benefiter_folder_number = $this->db_dependences->find_benefiter_folder_number($id);
        $benefiter_medical_history_list = $this->db_dependences->get_all_medical_visits_for_benefiter($id);
        $doctor_id = $this->db_dependences->get_logged_in_user_id();

        $benefiter_id = $benefiter->id;
        $medical_visits_number = $this->db_dependences->count_medical_visits_for_a_benefiter($id);
        // brings the medical location array from db
        $medical_locations = $this->db_dependences->get_all_medical_locations_lookup();
        $medical_locations_array = $this->general_use_services->reindex_array($medical_locations);
        $ExamResultsLookup = $this->db_dependences->get_medical_examination_results_from_lookup();

        // Post Validation
        $validator = $this->new_medical_visit_validator->medicalValidationService($request->all());
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
            $this->newMedicalVisit->save_new_medical_visit_tables($request->all());
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
                ->with('visit_submited_succesfully', $visit_submited_succesfully);
        }
    }
}
