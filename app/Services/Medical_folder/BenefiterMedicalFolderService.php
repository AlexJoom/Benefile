<?php namespace App\Services\Medical_folder;

// models used
use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\medical_chronic_conditions;
use App\Models\Benefiters_Tables_Models\medical_chronic_conditions_lookup;
use App\Models\Benefiters_Tables_Models\medical_diagnosis_results;
use App\Models\Benefiters_Tables_Models\medical_examination_results;
use App\Models\Benefiters_Tables_Models\medical_examinations;
use App\Models\Benefiters_Tables_Models\medical_hospitalizations;
use App\Models\Benefiters_Tables_Models\medical_visits;
use App\Models\Benefiters_Tables_Models\medical_laboratory_results;
use App\Models\Benefiters_Tables_Models\medical_examination_results_lookup;
use App\Models\Benefiters_Tables_Models\medical_medication;
use App\Models\Benefiters_Tables_Models\medical_medication_lookup;
use App\Models\Benefiters_Tables_Models\medical_referrals;
use App\Models\Benefiters_Tables_Models\medical_uploads;
use App\Models\Benefiters_Tables_Models\medical_incident_type_lookup;
use App\Models\Benefiters_Tables_Models\ICD10;
use App\Models\Benefiters_Tables_Models\medical_location_lookup;

// services used
use App\Services\DatesHelper;
use App\Services\Medical_folder\BenefiterMedicalFolderDBdependentService;
use App\Services\Validation_services\Medical_folder\BenefiterMedicalFolderValidationService;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use Validator;


/*
 *
 * This class contains all necessary in order to create and edit a medical visit
 *
 */
class BenefiterMedicalFolderService{

    private $datesHelper;
    private $medical_folder_validator;
    private $medical_folder_db_dependent_services;
    public function __construct(){
        // initialize dates helper
        $this->datesHelper = new DatesHelper();
        // initialize medical folder validator
        $this->medical_folder_validator = new BenefiterMedicalFolderValidationService();
        // initialize db dependent services for medical folder
        $this->medical_folder_db_dependent_services = new BenefiterMedicalFolderDBdependentService();
    }

    //-------------------------------------------------------------------------------------------//
    // PART 1 : validate the medical info frm the post

    public function medicalValidation($request){
        $this->medical_folder_validator->medicalValidationService($request);
    }

    //------------------------------------------------------------------------//
    // PART 2 : insert into DB benefiter medical tables
    // TODO add transaction to public function (not now)

    public function save_new_medical_visit_tables($request){
        // medical visit table
        $medicalVisit_id = $this->create_medical_visit($request);
        // chronic conditions table
        $this->save_medical_chronic_conditions($request, $medicalVisit_id);
        //medical_examination_results table
        $this->save_medical_examination_results($request, $medicalVisit_id);
        //medical_examinations table
        $this->save_medical_examinations($request, $medicalVisit_id);
        // laboratory results
        $this->save_medical_laboratory_results($request, $medicalVisit_id);
        // diagnosis results
        $this->save_medical_diagnosis_results($request, $medicalVisit_id);
        // hospitalizations
        $this->save_medical_hospitalizations($request, $medicalVisit_id);
        // medication table
        $this->save_medical_medication($request, $medicalVisit_id);
        // medical referrals
        $this->save_medical_referrals($request, $medicalVisit_id);
        // medical file uploads
        $this->save_medical_uploads($request, $medicalVisit_id);
    }

    //----------- medical_visit table ---------------------------------//
    private function create_medical_visit($request){
        $newMedicalVisit = new medical_visits();
        $newMedicalVisit->benefiter_id = $request['benefiter_id'];
        $newMedicalVisit->doctor_id = $request['doctor_id'];

        $newMedicalVisit->medical_location_id = $this->add_dynamically_medical_locations_to_lookup($request);
        $newMedicalVisit->medical_incident_id = $request['medical_incident_id'];
        $newMedicalVisit->medical_visit_date = $this->datesHelper->makeDBFriendlyDate($request['examination_date']);
        $newMedicalVisit->save();
        return $newMedicalVisit->id;
    }
    private function add_dynamically_medical_locations_to_lookup($request){
        if(!is_int($request['medical_location_id']) && !empty($request['new_medical_location'])){
            // add the input value to medical locations table and return the table id
            $new_medical_location = new medical_location_lookup();
            $new_medical_location->description = $request['new_medical_location'];
            $new_medical_location->save();

            return $new_medical_location->id;
        }
        // else just return the $request['medical_location_id']
        else{
            return $request['medical_location_id'];
        }
    }

    //----------- medical_chronic_conditions table -----------------------DONE//
    // DB save
    private function save_medical_chronic_conditions($request, $id){
        $request_medical_chronic_conditions = $this->get_medical_chronic_conditions($request);
        foreach($request_medical_chronic_conditions as $cc){
            if(!empty($cc)){
                $medical_chronic_conditions = new medical_chronic_conditions();
                // save to lookup first
                $medical_chronic_conditions_lookup = new medical_chronic_conditions_lookup();
                $medical_chronic_conditions_lookup->description = $cc;
                $medical_chronic_conditions_lookup->save();
                // then to chronic conditions table
                $medical_chronic_conditions->benefiters_id = $request['benefiter_id'];
                $medical_chronic_conditions->medical_visit_id = $id;
                $medical_chronic_conditions->description = $cc;
                $medical_chronic_conditions->chronic_condition_id = $medical_chronic_conditions_lookup->id;
                $medical_chronic_conditions->save();
            }
        }
    }
    // post request
    private function get_medical_chronic_conditions($request){
        $chronic_conditions = $request['chronic_conditions'];
        $chronic_conditions_array = [];
        foreach ($chronic_conditions as $cc){
            array_push($chronic_conditions_array, $cc);
        }
        return $chronic_conditions_array;
    }

    //----------- clinical_examination_results table ------------------//
    // DB save
    private function save_medical_examination_results($request, $id){
        if(!empty($request['examResultLoukup'])){
            $request_med_exams_results = $request['examResultLoukup'];
            $request_med_exams_description = $request['examResultDescription'];
            for($i=0; $i<count($request_med_exams_results) ; $i++){
                if(!empty($request_med_exams_results[$i])) {
                    for ($j = 0; $j < count($request_med_exams_results[$i]); $j++) {
                        if (!empty($request_med_exams_results[$i][$j])) {
                            $medical_examination_results = new medical_examination_results();
                            $medical_examination_results->description = $request_med_exams_description[$i];
                            $medical_examination_results->icd10_id = $request_med_exams_results[$i][$j];
                            $medical_examination_results->medical_visit_id = $id;
                            // get medical examinations list from the lookup table
                            $med_exams_lookup_item = medical_examination_results_lookup::where('id', '=', $i + 1)->first()['attributes']['id'];
                            $medical_examination_results->results_lookup_id = $med_exams_lookup_item;

                            $medical_examination_results->save();
                        }
                    }
                }
            }
        }
    }

    //----------- medical_examinations table --------------------------//
    // DB save
    private function save_medical_examinations($request, $id){
        $medical_examination = new medical_examinations();

        $medical_examination->height = $request['height'];
        $medical_examination->weight = $request['weight'];
        $medical_examination->temperature = $request['temperature'];
        $medical_examination->blood_pressure_systolic = $request['blood_pressure_systolic'];
        $medical_examination->blood_pressure_diastolic = $request['blood_pressure_diastolic'];
        $medical_examination->skull_perimeter = $request['skull_perimeter'];
        $medical_examination->examination_date = $this->datesHelper->makeDBFriendlyDate($request['examination_date']);
        $medical_examination->medical_visit_id = $id;

        $medical_examination->save();
    }

    //----------- medical_laboratory_results table --------------------//
    // DB save
    private function save_medical_laboratory_results($request, $id){
        $request_lab_results = $this->medical_laboratory_results($request);
        foreach($request_lab_results as $rlr){
            if(!empty($rlr)){
                $lab_results = new medical_laboratory_results();

                $lab_results->laboratory_results = $rlr;
                $lab_results->medical_visit_id = $id;

                $lab_results->save();
            }
        }
    }
    // post request
    private function medical_laboratory_results($request){
        $lab_results = $request['lab_results'];
        $lab_results_array = [];
        foreach ($lab_results as $lr){
            array_push($lab_results_array, $lr);
        }
        return $lab_results_array;
    }

    //----------- medical_diagnosis_results table ----------------------DONE//
    // DB save
    private function save_medical_diagnosis_results($request, $id){
        $request_diagnosis_results = $this->medical_diagnosis_results($request);
        foreach($request_diagnosis_results as $rdr){
            if(!empty($rdr)){
                $diagnosis_results = new medical_diagnosis_results();

                $diagnosis_results->diagnosis_results = $rdr;
                $diagnosis_results->medical_visit_id = $id;

                $diagnosis_results->save();
            }
        }
    }
    // post request
    private function medical_diagnosis_results($request){
        $diagnosis_results = $request['diagnosis_results'];
        $diagnosis_results_array = [];
        foreach ($diagnosis_results as $dr){
            array_push($diagnosis_results_array, $dr);
        }
        return $diagnosis_results_array;
    }

    //----------- medical_hospitalizations table ----------------------DONE//
    // DB save
    private function save_medical_hospitalizations($request, $id){
        $request_hospitalizations = $this->medical_hospitalizations($request);
        $request_hospitalization_dates = $this->medical_hospitalization_dates($request);
        foreach($request_hospitalizations as $i=>$rh){
            if(!empty($rh)){
                $hospitalization = new medical_hospitalizations();

                $hospitalization->hospitalizations = $rh;
                $hospitalization->hospitalization_date = $this->datesHelper->makeDBFriendlyDate($request_hospitalization_dates[$i]);
                $hospitalization->medical_visit_id = $id;

                $hospitalization->save();
            }
        }
    }
    // post request
    private function medical_hospitalizations($request){
        $hospitalizations = $request['hospitalization'];
        $hospitalizations_array = [];
        foreach ($hospitalizations as $h){
            array_push($hospitalizations_array, $h);
        }
        return $hospitalizations_array;
    }
    // post request
    private function medical_hospitalization_dates($request){
        $hospitalization_dates = $request['hospitalization_date'];
        $hospitalization_dates_array = [];
        foreach ($hospitalization_dates as $hd){
            array_push($hospitalization_dates_array, $hd);
        }
        return $hospitalization_dates_array;
    }

    //----------- medical_medication table ----------------------------DONE//
    // DB save
    private function save_medical_medication($request, $id){
        if(!empty($request['medication_name_from_lookup'])){
            $request_medication_name_from_lookup = $request['medication_name_from_lookup'];
        }

        if(!empty($request['medication_new_name'])){
            $request_medication_new_name = $request['medication_new_name'];
        }

        $request_medication_name = [];

        $request_medication_dosage = $request['medication_dosage'];
        $request_medication_duration = $request['medication_duration'];
        $request_supply_from_praksis = null;
        if(!empty($request['supply_from_praksis_hidden'])){
            $request_supply_from_praksis = $request['supply_from_praksis_hidden'];
        }

        $request_medication_Number = count($request_medication_dosage);

        for($i=0; $i<$request_medication_Number ; $i++){
            // Medicinal condition DB entry (save to DB only if all fields are filled)
            if(!empty($request_medication_dosage[$i]) && !empty($request_medication_duration[$i])) {
                $med_medication = new medical_medication();

                // check if the request comes from the auto complete select (from lookup)
                if (empty($request_medication_new_name[$i]) && !empty($request_medication_name_from_lookup[$i])) {
                    $request_medication_name[$i] = $request_medication_name_from_lookup[$i];

                    $med_medication->dosage = $request_medication_dosage[$i];
                    $med_medication->duration = $request_medication_duration[$i];
                    if(!empty($request_supply_from_praksis)){
                        $med_medication->supply_from_praksis = $request_supply_from_praksis[$i];
                    }else{
                        $med_medication->supply_from_praksis = 0;
                    }
                    $med_medication->medical_visit_id = $id;
                    $med_medication->medication_lookup_id = $request_medication_name[$i];

                    $med_medication->save();
                }
                // check if the request comes from the input field.
                else if(!empty($request_medication_new_name[$i])){
                    $request_medication_name[$i] = $request_medication_new_name[$i];

                    $med_medication_lookup = new medical_medication_lookup();
                    $med_medication_lookup->description = $request_medication_name[$i];
                    $med_medication_lookup->save();

                    // then continue to medication table
                    $med_medication->dosage = $request_medication_dosage[$i];
                    $med_medication->duration = $request_medication_duration[$i];
                    if(!empty($request_supply_from_praksis)){
                        $med_medication->supply_from_praksis = $request_supply_from_praksis[$i];
                    }else{
                        $med_medication->supply_from_praksis = 0;
                    }
                    $med_medication->medical_visit_id = $id;
                    $med_medication->medication_lookup_id = $med_medication_lookup->id;

                    $med_medication->save();
                }
            }
        }
    }

    //----------- medical_referrals table -----------------------------//
    // DB save
    private function save_medical_referrals($request, $id){
        $request_medical_referrals = $this->medical_referrals($request);
        $request_medical_referrals_is_done = $this->medical_referrals_is_done($request);
        foreach($request_medical_referrals as $i => $rmr){
            if(!empty($rmr)){
                $med_referral = new medical_referrals();
                $med_referral->referrals = $rmr;
                $med_referral->medical_visit_id = $id;
                $med_referral->is_done_id = $request_medical_referrals_is_done[$i];
                $med_referral->save();
            }
        }
    }
    // post request
    private function medical_referrals($request){
        $referrals = $request['referrals'];
        $referrals_array = [];
        foreach ($referrals as $ref){
            array_push($referrals_array, $ref);
        }
        return $referrals_array;
    }
    // post request
    private function medical_referrals_is_done($request){
        $referrals_is_done = $request['is_done_id'];
        $referrals_is_done_array = [];
        foreach ($referrals_is_done as $rid){
            array_push($referrals_is_done_array, $rid);
        }
        return $referrals_is_done_array;
    }

    //----------- medical_uploads table -------------------------------//
    // DB save
    private function save_medical_uploads($request, $id){
        $request_upload_file_description = $request['upload_file_description'];
        $request_upload_file_title = $request['upload_file_title'];

        $file = Input::file('upload_file_title');

        $files_numbers = count($request_upload_file_title);
        for ($i = 0; $i < $files_numbers; $i++) {
            if(!empty($file[$i])){

                $path_after_public_folder = '/uploads/medical-visit-uploads/';
                $path = public_path() . $path_after_public_folder;
                $fileName = 'medical_visit-' . $id . $file[$i]->getClientOriginalName();
                $file[$i]->move($path, $fileName); // uploading file to given path
                $medical_upload = new medical_uploads();
                $medical_upload->title = $fileName;
                $medical_upload->description = $request_upload_file_description[$i];
                $medical_upload->path = $path_after_public_folder;
                $medical_upload->medical_visit_id = $id;

                $medical_upload->save();
            }
        }
    }


    // ---------------------------------------------------------------------------------------------- //
    // PART 3 : EDIT SAVED MEDICAL VISIT

    public function update_medical_visit_tables($request, $selected_medical_visit_id){
        // medical visit table
        $updatedMedicalVisit_id = $this->update_medical_visit($request, $selected_medical_visit_id);
        // chronic conditions table
        $this->update_medical_chronic_conditions($request, $updatedMedicalVisit_id);
        //medical_examination_results table
        $this->update_medical_examination_results($request, $updatedMedicalVisit_id);
        //medical_examinations table
        $this->update_medical_examinations($request, $updatedMedicalVisit_id);
        // laboratory results
        $this->update_medical_laboratory_results($request, $updatedMedicalVisit_id);
        // diagnosis results
        $this->update_medical_diagnosis_results($request, $updatedMedicalVisit_id);
        // hospitalizations
        $this->update_medical_hospitalizations($request, $updatedMedicalVisit_id);
        // medication table
        $this->update_medical_medication($request, $updatedMedicalVisit_id);
        // medical referrals
        $this->update_medical_referrals($request, $updatedMedicalVisit_id);
        // medical file uploads
        $this->update_medical_uploads($request, $updatedMedicalVisit_id);

    }

    //----------- medical_visit table ----------------------------------//
    private function update_medical_visit($request, $selected_medical_visit_id){
        $updatedMedicalVisit = $this->medical_folder_db_dependent_services->find_medical_visit_by_id($selected_medical_visit_id);

        $updatedMedicalVisit->benefiter_id = $request['benefiter_id'];
        $updatedMedicalVisit->doctor_id = $request['doctor_id'];
        $updatedMedicalVisit->medical_location_id = $this->add_dynamically_medical_locations_to_lookup($request);
        $updatedMedicalVisit->medical_incident_id = $request['medical_incident_id'];
        $updatedMedicalVisit->medical_visit_date = $this->datesHelper->makeDBFriendlyDate($request['examination_date']);
        $updatedMedicalVisit->save();
        return $updatedMedicalVisit->id;
    }

    //----------- medical_chronic_conditions table ---------------------//
    // DB save
    private function update_medical_chronic_conditions($request, $selected_medical_visit_id){
        $request_medical_chronic_conditions = $this->get_updated_chronic_conditions($request);
        $requests_count = count($request_medical_chronic_conditions);
        $saved_medical_chronic_conditions = $this->medical_folder_db_dependent_services->find_medical_chronic_conditions_by_medical_visit_id($selected_medical_visit_id);
        $saved_count = count($saved_medical_chronic_conditions);
        $counter = 0;
        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_count){
            for($i=0; $i<$requests_count ; $i++) {
                if ($counter < $saved_count) {
                    if(!empty($request_medical_chronic_conditions[$i])){
                        $medical_chronic_condition = $this->medical_folder_db_dependent_services->find_medical_chronic_condition_by_id($saved_medical_chronic_conditions[$counter]['id']);
                        // save to lookup first
                        $medical_chronic_conditions_lookup = new medical_chronic_conditions_lookup();
                        $medical_chronic_conditions_lookup->description = $request_medical_chronic_conditions[$i];
                        $medical_chronic_conditions_lookup->save();
                        // then update chronic conditions table
                        $medical_chronic_condition->benefiters_id = $request['benefiter_id'];
                        $medical_chronic_condition->medical_visit_id = $selected_medical_visit_id;
                        $medical_chronic_condition->description = $request_medical_chronic_conditions[$i];
                        $medical_chronic_condition->chronic_condition_id = $medical_chronic_conditions_lookup->id;
                        $medical_chronic_condition->save();
                    }
                } else {
                    if(!empty($request_medical_chronic_conditions[$i])){
                        $medical_chronic_conditions = new medical_chronic_conditions();
                        // save to lookup first
                        $medical_chronic_conditions_lookup = new medical_chronic_conditions_lookup();
                        $medical_chronic_conditions_lookup->description = $request_medical_chronic_conditions[$i];
                        $medical_chronic_conditions_lookup->save();
                        // then to chronic conditions table
                        $medical_chronic_conditions->benefiters_id = $request['benefiter_id'];
                        $medical_chronic_conditions->medical_visit_id = $selected_medical_visit_id;
                        $medical_chronic_conditions->description = $request_medical_chronic_conditions[$i];
                        $medical_chronic_conditions->chronic_condition_id = $medical_chronic_conditions_lookup->id;
                        $medical_chronic_conditions->save();
                    }
                }
                $counter++;
            }
            // if the request array is smaller then update some rows and delete the rest
        }else{
            for($j=0; $j<$saved_count; $j++){
                if ($counter < $requests_count) {
                    if(!empty($request_medical_chronic_conditions[$j])){
                        $medical_chronic_condition = $this->medical_folder_db_dependent_services->find_medical_chronic_condition_by_id($saved_medical_chronic_conditions[$counter]['id']);

                        // save to lookup first
                        $medical_chronic_conditions_lookup = new medical_chronic_conditions_lookup();
                        $medical_chronic_conditions_lookup->description = $request_medical_chronic_conditions[$j];
                        $medical_chronic_conditions_lookup->save();
                        // then update chronic conditions table
                        $medical_chronic_condition->benefiters_id = $request['benefiter_id'];
                        $medical_chronic_condition->medical_visit_id = $selected_medical_visit_id;
                        $medical_chronic_condition->description = $request_medical_chronic_conditions[$j];
                        $medical_chronic_condition->chronic_condition_id = $medical_chronic_conditions_lookup->id;
                        $medical_chronic_condition->save();
                    }
                } else {
                    $medical_chronic_condition = $this->medical_folder_db_dependent_services->find_medical_chronic_condition_by_id($saved_medical_chronic_conditions[$counter]['id']);
                    $medical_chronic_condition->delete();
                }
                $counter++;
            }
        }
    }
    // post request
    private function get_updated_chronic_conditions($request){
        $chronic_conditions = $request['chronic_conditions'];
        $chronic_conditions_array = [];
        foreach ($chronic_conditions as $cc){
            array_push($chronic_conditions_array, $cc);
        }
        return $chronic_conditions_array;
    }

    //----------- clinical_examination_results table -------------------//
    // DB save
    private function update_medical_examination_results($request, $selected_medical_visit_id){
        $request_med_exams_results = $request['examResultLoukup'];
        $request_med_exams_description = $request['examResultDescription'];
        // for every clinical result
        for($i=0; $i<count($request_med_exams_description) ; $i++){
            // in case where everything is removed from the form
            $requests_icd10_count = 0;
            if(!empty($request_med_exams_results[$i])) {
                $requests_icd10_count = count($request_med_exams_results[$i]);
            }
            $saved_examinations_with_same_clinical_result= $this->medical_folder_db_dependent_services->find_examinations_with_same_clinical_result($selected_medical_visit_id, $i+1);
            $counter = 0;
            // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
            if($requests_icd10_count > count($saved_examinations_with_same_clinical_result)){
                if(!empty($request_med_exams_results[$i])) {
                    // for every icd10 condition
                    for ($j = 0; $j < count($request_med_exams_results[$i]); $j++) {
                        if (!empty($request_med_exams_results[$i][$j])) {
                            // update what is saved
                            if($counter < count($saved_examinations_with_same_clinical_result)){
//                                $medical_examination_result = medical_examination_results::find($saved_examinations_with_same_clinical_result[$counter]['id']);
                                $medical_examination_result = $this->medical_folder_db_dependent_services->find_medical_examination_result_by_id($saved_examinations_with_same_clinical_result[$counter]['id']);
                                $medical_examination_result->description = $request_med_exams_description[$i];
                                $medical_examination_result->icd10_id = $request_med_exams_results[$i][$j];
                                $medical_examination_result->medical_visit_id = $selected_medical_visit_id;
                                $med_exams_lookup_item = $this->medical_folder_db_dependent_services->find_medical_examination_results_lookup_id($i+1);
                                $medical_examination_result->results_lookup_id = $med_exams_lookup_item;

                                $medical_examination_result->save();
                                //add new rows for the new requests
                            }else{
                                $medical_examination_results = new medical_examination_results();
                                $medical_examination_results->description = $request_med_exams_description[$i];
                                $medical_examination_results->icd10_id = $request_med_exams_results[$i][$j];
                                $medical_examination_results->medical_visit_id = $selected_medical_visit_id;
                                // get medical examinations list from the lookup table
                                $med_exams_lookup_item = $this->medical_folder_db_dependent_services->find_medical_examination_results_lookup_id($i+1);
                                $medical_examination_results->results_lookup_id = $med_exams_lookup_item;

                                $medical_examination_results->save();
                            }
                            $counter++;
                        }
                    } // end for every icd10 condition
                }
                // else if the request array is smaller then for the saved ones, update some rows and delete the rest
            }else{
                for($j=0; $j<count($saved_examinations_with_same_clinical_result); $j++){
                    // update already saved rows
                    if ($counter < $requests_icd10_count) {
                        if(!empty($request_med_exams_results[$i][$j])){
                            $medical_examination_result = $this->medical_folder_db_dependent_services->find_medical_examination_result_by_id($saved_examinations_with_same_clinical_result[$counter]['id']);
                            $medical_examination_result->description = $request_med_exams_description[$i];
                            $medical_examination_result->icd10_id = $request_med_exams_results[$i][$j];
                            $medical_examination_result->medical_visit_id = $selected_medical_visit_id;
                            // get medical examinations list from the lookup table
                            $med_exams_lookup_item = $this->medical_folder_db_dependent_services->find_medical_examination_results_lookup_id($i+1);
                            $medical_examination_result->results_lookup_id = $med_exams_lookup_item;

                            $medical_examination_result->save();
                        }
                        // else delete extra rows
                    } else {
                        $medical_examination_result = $this->medical_folder_db_dependent_services->find_medical_examination_result_by_id($saved_examinations_with_same_clinical_result[$counter]['id']);
                        $medical_examination_result->delete();
                    }
                    $counter++;
                }
            }
        } // end for every clinical result
    }

    //----------- medical_examinations table ---------------------------//
    // DB save
    private function update_medical_examinations($request, $selected_medical_visit_id){
//        $medical_examination = medical_examinations::where("medical_visit_id", $selected_medical_visit_id)->first();
        $medical_examination = $this->medical_folder_db_dependent_services->find_medical_examination_results_with_same_medical_visit_id($selected_medical_visit_id);
        $medical_examination->height = $request['height'];
        $medical_examination->weight = $request['weight'];
        $medical_examination->temperature = $request['temperature'];
        $medical_examination->blood_pressure_systolic = $request['blood_pressure_systolic'];
        $medical_examination->blood_pressure_diastolic = $request['blood_pressure_diastolic'];
        $medical_examination->skull_perimeter = $request['skull_perimeter'];
        $medical_examination->examination_date = $this->datesHelper->makeDBFriendlyDate($request['examination_date']);
        $medical_examination->medical_visit_id = $selected_medical_visit_id;

        $medical_examination->save();
    }

    //----------- medical_laboratory_results table ---------------------//
    // DB save
    private function update_medical_laboratory_results($request, $selected_medical_visit_id){
        $request_lab_results = $this->update_laboratory_results($request);
        $requests_count = count($request_lab_results);
        $saved_lab_results = $this->medical_folder_db_dependent_services->find_medical_lab_results_with_same_medical_visit_id($selected_medical_visit_id);
        $saved_lab_results_count = count($saved_lab_results);
        $counter = 0;
        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_lab_results_count){
            for($i=0; $i<$requests_count ; $i++) {
                // update what is saved
                if ($counter < $saved_lab_results_count) {
                    if(!empty($request_lab_results[$i])){
                        $lab_result = $this->medical_folder_db_dependent_services->find_laboratory_result_by_id($saved_lab_results[$counter]['id']);
                        $lab_result->laboratory_results = $request_lab_results[$i];
                        $lab_result->medical_visit_id = $selected_medical_visit_id;
                        $lab_result->save();
                    }
                    //add new rows for the new requests
                } else {
                    if(!empty($request_lab_results[$i])){
                        $lab_results = new medical_laboratory_results();
                        $lab_results->laboratory_results = $request_lab_results[$i];
                        $lab_results->medical_visit_id = $selected_medical_visit_id;
                        $lab_results->save();
                    }
                }
                $counter++;
            }
            // else if the request array is smaller then update some rows and delete the rest
        }else{
            for($j=0; $j<$saved_lab_results_count; $j++){
                // update already saved rows
                if ($counter < $requests_count) {
                    if(!empty($request_lab_results[$j])){
                        $lab_result = $this->medical_folder_db_dependent_services->find_laboratory_result_by_id($saved_lab_results[$counter]['id']);
                        $lab_result->laboratory_results = $request_lab_results[$j];
                        $lab_result->medical_visit_id = $selected_medical_visit_id;
                        $lab_result->save();
                    }
                    // else delete extra rows
                } else {
                    $lab_result = $this->medical_folder_db_dependent_services->find_laboratory_result_by_id($saved_lab_results[$counter]['id']);
                    $lab_result->delete();
                }
                $counter++;
            }
        }
    }
    // post request
    private function update_laboratory_results($request){
        $lab_results = $request['lab_results'];
        $lab_results_array = [];
        foreach ($lab_results as $lr){
            array_push($lab_results_array, $lr);
        }
        return $lab_results_array;
    }

    
    //----------- medical_diagnosis_results table ----------------------DONE//
    // DB save
    private function update_medical_diagnosis_results($request, $selected_medical_visit_id){
        $request_diagnosis_results = $this->update_diagnosis_results($request);
        $requests_count = count($request_diagnosis_results);
        $saved_diagnosis_results = medical_diagnosis_results::where("medical_visit_id", $selected_medical_visit_id)->get();
        $saved_diagnosis_results_count = count($saved_diagnosis_results);
        $counter = 0;
        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_diagnosis_results_count){
            for($i=0; $i<$requests_count ; $i++) {
                // update what is saved
                if ($counter < $saved_diagnosis_results_count) {
                    if(!empty($request_diagnosis_results[$i])){
                        $diagnosis_result = medical_diagnosis_results::find($saved_diagnosis_results[$counter]['id']);
                        $diagnosis_result->diagnosis_results = $request_diagnosis_results[$i];
                        $diagnosis_result->medical_visit_id = $selected_medical_visit_id;
                        $diagnosis_result->save();
                    }
                    //add new rows for the new requests
                } else {
                    if(!empty($request_diagnosis_results[$i])){
                        $diagnosis_results = new medical_diagnosis_results();
                        $diagnosis_results->diagnosis_results = $request_diagnosis_results[$i];
                        $diagnosis_results->medical_visit_id = $selected_medical_visit_id;
                        $diagnosis_results->save();
                    }
                }
                $counter++;
            }
            // else if the request array is smaller then update some rows and delete the rest
        }else{
            for($j=0; $j<$saved_diagnosis_results_count; $j++){
                // update already saved rows
                if ($counter < $requests_count) {
                    if(!empty($request_diagnosis_results[$j])){
                        $diagnosis_result = medical_diagnosis_results::find($saved_diagnosis_results[$counter]['id']);
                        $diagnosis_result->diagnosis_results = $request_diagnosis_results[$j];
                        $diagnosis_result->medical_visit_id = $selected_medical_visit_id;
                        $diagnosis_result->save();
                    }
                    // else delete extra rows
                } else {
                    $diagnosis_result = medical_diagnosis_results::find($saved_diagnosis_results[$counter]['id']);
                    $diagnosis_result->delete();
                }
                $counter++;
            }
        }
    }
    // post request
    private function update_diagnosis_results($request){
        $diagnosis_results = $request['diagnosis_results'];
        $diagnosis_results_array = [];
        foreach ($diagnosis_results as $dr){
            array_push($diagnosis_results_array, $dr);
        }
        return $diagnosis_results_array;
    }

    //----------- medical_hospitalizations table ----------------------DONE//
    // DB save
    private function update_medical_hospitalizations($request, $selected_medical_visit_id){
        $request_hospitalizations = $this->medical_hospitalizations($request);
        $request_hospitalization_dates = $this->medical_hospitalization_dates($request);
        $requests_count = count($request_hospitalizations);
        $saved_hospitalizations = medical_hospitalizations::where("medical_visit_id", $selected_medical_visit_id)->get();
        $saved_hospitalizations_count = count($saved_hospitalizations);
        $counter = 0;
        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_hospitalizations_count){
            for($i=0; $i<$requests_count ; $i++) {
                // update what is saved
                if ($counter < $saved_hospitalizations_count) {
                    if(!empty($request_hospitalizations[$i])){
                        $hospitalization = medical_hospitalizations::find($saved_hospitalizations[$counter]['id']);
                        $hospitalization->hospitalizations = $request_hospitalizations[$i];
                        $hospitalization->hospitalization_date = $this->datesHelper->makeDBFriendlyDate($request_hospitalization_dates[$i]);
                        $hospitalization->medical_visit_id = $selected_medical_visit_id;
                        $hospitalization->save();
                    }
                    //add new rows for the new requests
                } else {
                    if(!empty($request_hospitalizations[$i])){
                        $hospitalization = new medical_hospitalizations();
                        $hospitalization->hospitalizations = $request_hospitalizations[$i];
                        $hospitalization->hospitalization_date = $this->datesHelper->makeDBFriendlyDate($request_hospitalization_dates[$i]);
                        $hospitalization->medical_visit_id = $selected_medical_visit_id;
                        $hospitalization->save();
                    }
                }
                $counter++;
            }
            // else if the request array is smaller then update some rows and delete the rest
        }else{
            for($j=0; $j<$saved_hospitalizations_count; $j++){
                // update already saved rows
                if ($counter < $requests_count) {
                    if(!empty($request_hospitalizations[$j])){
                        $hospitalization = medical_hospitalizations::find($saved_hospitalizations[$counter]['id']);
                        $hospitalization->hospitalizations = $request_hospitalizations[$j];
                        $hospitalization->hospitalization_date = $this->datesHelper->makeDBFriendlyDate($request_hospitalization_dates[$j]);
                        $hospitalization->medical_visit_id = $selected_medical_visit_id;
                        $hospitalization->save();
                    }
                    // else delete extra rows
                } else {
                    $hospitalization = medical_hospitalizations::find($saved_hospitalizations[$counter]['id']);
                    $hospitalization->delete();
                }
                $counter++;
            }
        }
    }

    //----------- medical_medication table ----------------------------DONE//
    // DB save
    private function update_medical_medication($request, $selected_medical_visit_id){
        if(!empty($request['medication_name_from_lookup'])){
            $request_medication_name_from_lookup = $request['medication_name_from_lookup'];
        }
        if(!empty($request['medication_new_name'])){
            $request_medication_new_name = $request['medication_new_name'];
        }
        $request_medication_name = [];
        $request_medication_dosage = $request['medication_dosage'];
        $request_medication_duration = $request['medication_duration'];
        $request_supply_from_praksis = null;

        $requests_count = count($request_medication_dosage);
        $saved_medication = $this->medical_folder_db_dependent_services->find_medications_with_same_medical_visit_id($selected_medical_visit_id);
        $saved_medication_count = count($saved_medication);
        $counter = 0;

        if(!empty($request['supply_from_praksis_hidden'])){
            $request_supply_from_praksis = $request['supply_from_praksis_hidden'];
        }

        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_medication_count){
            for($i=0; $i<$requests_count ; $i++) {
                if ($counter < $saved_medication_count) {
                    if(!empty($request_medication_name_from_lookup[$i])){
                        $med_medication = $this->medical_folder_db_dependent_services->find_medication_by_id($saved_medication[$counter]['id']);
                        // check if the request comes from the auto complete select (from lookup)
                        if (empty($request_medication_new_name[$i])) {
                            $request_medication_name[$i] = $request_medication_name_from_lookup[$i];
                            $med_medication->dosage = $request_medication_dosage[$i];
                            $med_medication->duration = $request_medication_duration[$i];
                            if(!empty($request_supply_from_praksis)){
                                $med_medication->supply_from_praksis = $request_supply_from_praksis[$i];
                            }else{
                                $med_medication->supply_from_praksis = 0;
                            }
                            $med_medication->medical_visit_id = $selected_medical_visit_id;
                            $med_medication->medication_lookup_id = $request_medication_name[$i];
                            $med_medication->save();
                        }
                        // check if the request comes from the input field.
                        else{
                            $request_medication_name[$i] = $request_medication_new_name[$i];
                            $med_medication_lookup = new medical_medication_lookup();
                            $med_medication_lookup->description = $request_medication_name[$i];
                            $med_medication_lookup->save();

                            // then continue to medication table
                            $med_medication->dosage = $request_medication_dosage[$i];
                            $med_medication->duration = $request_medication_duration[$i];
                            if(!empty($request_supply_from_praksis)){
                                $med_medication->supply_from_praksis = $request_supply_from_praksis[$i];
                            }else{
                                $med_medication->supply_from_praksis = 0;
                            }
                            $med_medication->medical_visit_id = $selected_medical_visit_id;
                            $med_medication->medication_lookup_id = $med_medication_lookup->id;
                            $med_medication->save();
                        }
                    }
                    // here new rows are added
                } else {
//                    if(!empty($request_lab_results[$i])){
                    if(!empty($request_medication_dosage[$i]) && !empty($request_medication_duration[$i])) {
                        $med_medication = new medical_medication();
                        // check if the request comes from the auto complete select (from lookup)
                        if (empty($request_medication_new_name[$i])) {
                            $request_medication_name[$i] = $request_medication_name_from_lookup[$i];
                            $med_medication->dosage = $request_medication_dosage[$i];
                            $med_medication->duration = $request_medication_duration[$i];
                            if(!empty($request_supply_from_praksis)){
                                $med_medication->supply_from_praksis = $request_supply_from_praksis[$i];
                            }else{
                                $med_medication->supply_from_praksis = 0;
                            }
                            $med_medication->medical_visit_id = $selected_medical_visit_id;
                            $med_medication->medication_lookup_id = $request_medication_name[$i];
                            $med_medication->save();
                        }
                        // check if the request comes from the input field.
                        else{
                            $request_medication_name[$i] = $request_medication_new_name[$i];
                            $med_medication_lookup = new medical_medication_lookup();
                            $med_medication_lookup->description = $request_medication_name[$i];
                            $med_medication_lookup->save();

                            // then continue to medication table
                            $med_medication->dosage = $request_medication_dosage[$i];
                            $med_medication->duration = $request_medication_duration[$i];
                            if(!empty($request_supply_from_praksis)){
                                $med_medication->supply_from_praksis = $request_supply_from_praksis[$i];
                            }else{
                                $med_medication->supply_from_praksis = 0;
                            }
                            $med_medication->medical_visit_id = $selected_medical_visit_id;
                            $med_medication->medication_lookup_id = $med_medication_lookup->id;
                            $med_medication->save();
                        }
                    }
//                    }
                }
                $counter++;
            }
            // if the request array is smaller then update some rows and delete the rest
        }else{
            for($j=0; $j<$saved_medication_count; $j++){
                if ($counter < $requests_count) {
//                    if(!empty($request_lab_results[$j])){
                    $med_medication = $this->medical_folder_db_dependent_services->find_medication_by_id($saved_medication[$counter]['id']);
                    // check if the request comes from the auto complete select (from lookup)
                    if (empty($request_medication_new_name[$j])) {
                        $request_medication_name[$j] = $request_medication_name_from_lookup[$j];
                        $med_medication->dosage = $request_medication_dosage[$j];
                        $med_medication->duration = $request_medication_duration[$j];
                        if(!empty($request_supply_from_praksis)){
                            $med_medication->supply_from_praksis = $request_supply_from_praksis[$j];
                        }else{
                            $med_medication->supply_from_praksis = 0;
                        }
                        $med_medication->medical_visit_id = $selected_medical_visit_id;
                        $med_medication->medication_lookup_id = $request_medication_name[$j];
                        $med_medication->save();
                    }
                    // check if the request comes from the input field.
                    else{
                        $request_medication_name[$j] = $request_medication_new_name[$j];
                        $med_medication_lookup = new medical_medication_lookup();
                        $med_medication_lookup->description = $request_medication_name[$j];
                        $med_medication_lookup->save();

                        // then continue to medication table
                        $med_medication->dosage = $request_medication_dosage[$j];
                        $med_medication->duration = $request_medication_duration[$j];
                        if(!empty($request_supply_from_praksis)){
                            $med_medication->supply_from_praksis = $request_supply_from_praksis[$j];
                        }else{
                            $med_medication->supply_from_praksis = 0;
                        }
                        $med_medication->medical_visit_id = $selected_medical_visit_id;
                        $med_medication->medication_lookup_id = $med_medication_lookup->id;
                        $med_medication->save();
                    }
//                    }
                } else {
                    $med_medication = $this->medical_folder_db_dependent_services->find_medication_by_id($saved_medication[$counter]['id']);
                    $med_medication->delete();
                }
                $counter++;
            }
        }
    }

    //----------- medical_referrals table ------------------------------//
    // DB save
    private function update_medical_referrals($request, $selected_medical_visit_id){
        $request_medical_referrals = $this->update_requested_medical_referrals($request);
        $request_medical_referrals_is_done = $this->medical_referrals_is_done($request);
        $requests_count = count($request_medical_referrals);
        $saved_medical_referrals = $this->medical_folder_db_dependent_services->find_medical_referrals_with_same_medical_visit_id($selected_medical_visit_id);
        $saved_medical_referrals_count = count($saved_medical_referrals);
        $counter = 0;

        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_medical_referrals_count){
            for($i=0; $i<$requests_count ; $i++) {
                if ($counter < $saved_medical_referrals_count) {
                    if(!empty($request_medical_referrals[$i])){
                        $med_referral = $this->medical_folder_db_dependent_services->find_medical_referral_by_id($saved_medical_referrals[$counter]['id']);
                        $med_referral->referrals = $request_medical_referrals[$i];
                        $med_referral->medical_visit_id = $selected_medical_visit_id;
                        $med_referral->is_done_id = $request_medical_referrals_is_done[$i];
                        $med_referral->save();
                    }
                } else {
                    if(!empty($request_medical_referrals[$i])){
                        $med_referral = new medical_referrals();
                        $med_referral->referrals = $request_medical_referrals[$i];
                        $med_referral->medical_visit_id = $selected_medical_visit_id;
                        $med_referral->is_done_id = $request_medical_referrals_is_done[$i];
                        $med_referral->save();
                    }
                }
                $counter++;
            }
            // if the request array is smaller then update some rows and delete the rest
        }else{
            for($j=0; $j<$saved_medical_referrals_count; $j++){
                if ($counter < $requests_count) {
                    if(!empty($request_medical_referrals[$j])){
                        $med_referral = $this->medical_folder_db_dependent_services->find_medical_referral_by_id($saved_medical_referrals[$counter]['id']);
                        $med_referral->referrals = $request_medical_referrals[$j];
                        $med_referral->medical_visit_id = $selected_medical_visit_id;
                        $med_referral->is_done_id = $request_medical_referrals_is_done[$j];
                        $med_referral->save();
                    }
                } else {
                    $med_referral = $this->medical_folder_db_dependent_services->find_medical_referral_by_id($saved_medical_referrals[$counter]['id']);
                    $med_referral->delete();
                }
                $counter++;
            }
        }
    }
    // post request
    private function update_requested_medical_referrals($request){
        $referrals = $request['referrals'];
        $referrals_array = [];
        foreach ($referrals as $ref){
            array_push($referrals_array, $ref);
        }
        return $referrals_array;
    }

    //----------- medical_uploads table --------------------------------//
    // DB save
    private function update_medical_uploads($request, $selected_medical_visit_id){
        $path_after_public_folder = '/uploads/medical-visit-uploads/';
        $path = public_path() . $path_after_public_folder;
        $request_upload_file_description = $request['upload_file_description'];
        $request_upload_file_title = $request['upload_file_title'];
        $file = Input::file('upload_file_title');
        $requests_count = count($request_upload_file_title);

        $saved_files = $this->medical_folder_db_dependent_services->find_medical_uploads_with_same_medical_visit_id($selected_medical_visit_id);
        $saved_files_count = count($saved_files);
        $counter = 0;
        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_files_count){
            for($i=0; $i<$requests_count ; $i++) {
                if ($counter < $saved_files_count) {
                    if(!empty($file[$i])){
                        $fileName = 'medical_visit-' . $selected_medical_visit_id . $file[$i]->getClientOriginalName();
                        $file[$i]->move($path, $fileName); // uploading file to given path
                        $medical_upload = $this->medical_folder_db_dependent_services->find_medical_upload_by_id($saved_files[$counter]['id']);
                        $medical_upload->title = $fileName;
                        $medical_upload->description = $request_upload_file_description[$i];
                        $medical_upload->path = $path_after_public_folder;
                        $medical_upload->medical_visit_id = $selected_medical_visit_id;
                        $medical_upload->save();
                    }
                } else {
                    if(!empty($file[$i])){
//                    if(!empty($request_medical_referrals[$i])){
                        $fileName = 'medical_visit-' . $selected_medical_visit_id . $file[$i]->getClientOriginalName();
                        $file[$i]->move($path, $fileName); // uploading file to given path
                        $medical_upload = new medical_uploads();
                        $medical_upload->title = $fileName;
                        $medical_upload->description = $request_upload_file_description[$i];
                        $medical_upload->path = $path_after_public_folder;
                        $medical_upload->medical_visit_id = $selected_medical_visit_id;
                        $medical_upload->save();
                    }
                }
                $counter++;
            }
            // if the request array is smaller then update some rows and delete the rest
        }else{
            for($j=0; $j<$saved_files_count; $j++){
                if ($counter < $requests_count) {
                    $medical_upload = $this->medical_folder_db_dependent_services->find_medical_upload_by_id($saved_files[$counter]['id']);
                    $medical_upload->description = $request_upload_file_description[$j];
                    if(!empty($file[$j])){
                        $fileName = 'medical_visit-' . $selected_medical_visit_id . $file[$j]->getClientOriginalName();
                        $file[$j]->move($path, $fileName); // uploading file to given path
                        $medical_upload->title = $fileName;
                        $medical_upload->path = $path_after_public_folder;
                        $medical_upload->medical_visit_id = $selected_medical_visit_id;
                    }
                    $medical_upload->save();
                } else {
                    $medical_upload = $this->medical_folder_db_dependent_services->find_medical_upload_by_id($saved_files[$counter]['id']);
                    $medical_upload->delete();
                }
                $counter++;
            }
        }
    }

    // --------------------------------------------------------------------------------------------------------------//
    // PART 3 : END
    //---------------------------------------------------------------------------------------------------------------//
}
