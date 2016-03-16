<?php namespace app\Services;

use App\Models\Benefiters_Tables_Models\medical_chronic_conditions;
use App\Models\Benefiters_Tables_Models\medical_chronic_conditions_lookup;
use App\Models\Benefiters_Tables_Models\medical_examination_results;
use App\Models\Benefiters_Tables_Models\medical_examinations;
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
use App\Services\DatesHelper;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use Validator;

class BenefiterMedicalFolderService
{

    private $datesHelper;

    public function __construct()
    {
        // initialize dates helper
        $this->datesHelper = new DatesHelper();
    }

    //-----------------------------------------------//
    // PART 1 : validate the medical info frm the post
    //-----------------------------------------------//
    public function medicalValidation($request){
        $rules = array(
            'examination_date'         => 'required|date',
            'medical_location_id'      => 'integer',
            'medical_incident_id'      => 'integer',
            'height'                   => 'numeric',
            'weight'                   => 'numeric',
            'temperature'              => 'numeric',
            'blood_pressure_systolic'  => 'numeric',
            'blood_pressure_diastolic' => 'numeric',
            'skull_perimeter'          => 'numeric'
        );
        // Push the dynamic elements into the rule array
        $chronic_conditions = $request['chronic_conditions'];
        foreach ($chronic_conditions as $cc){
            array_push($rules, [$cc=>'max:255']);
        }

        // TODO Change the way of exam results validation
        // Push the dynamic elements into the rule array
        if(!empty($request['examResultLoukup'])){
            $examResultsDescription = $request['examResultDescription'];
            $examResults = $request['examResultLoukup'];
            for($i=0; $i<count($examResults) ; $i++) {
                if(!empty($examResults[$i]) && !empty($examResultsDescription[$i])){
                    for ($j = 0; $j < count($examResults[$i]); $j++) {
                        array_push($rules, [$examResultsDescription[$i]=>'max:255']);
                        array_push($rules, [$examResults[$i][$j]=>'max:255']);
                    }
                }
            }
        }
        // Push the dynamic elements into the rule array
        $lab_results = $request['lab_results'];
        foreach ($lab_results as $lr){
            array_push($rules, [$lr=>'max:255']);
        }

        // Push the dynamic elements into the rule array
        if(!empty($request['medication_name']) && !empty($request->medication_dosage)
                                               && !empty($request->medication_duration)
                                               && !empty($request->supply_from_praksis_hidden)){
            $request_medication_name = $request->medication_name;
            $request_medication_dosage = $request->medication_dosage;
            $request_medication_duration = $request->medication_duration;
            $request_supply_from_praksis = $request->supply_from_praksis_hidden;

            for($i=0 ; $i<count($request_medication_name) ; $i++){
                array_push($rules, [$request_medication_name[$i]=>'max:255']);
                array_push($rules, [$request_medication_dosage[$i]=>'max:255']);
                array_push($rules, [$request_medication_duration[$i]=>'max:255']);
                array_push($rules, [$request_supply_from_praksis[$i]=>'max:255']);
            }
        }

//        $medicationList = $request['medicationList'];
//        foreach ($medicationList as $ml){
//            array_push($rules, [$ml=>'max:255']);
//        }

        // Push the dynamic elements into the rule array
        $referrals = $request['referrals'];
        foreach ($referrals as $ref){
            array_push($rules, [$ref=>'max:255']);
        }

        // Push the dynamic elements into the rule array
        $upload_file_description = $request['upload_file_description'];
        foreach ($upload_file_description as $fd){
            array_push($rules, [$fd=>'max:255']);
        }

        // Push the dynamic elements into the rule array
        // TODO ADD IF NESSESARY VALIDATION FOR FILE UPLOADS
//        $upload_file_title = $request['upload_file_title'];
//        if(!empty($upload_file_title)){
//            for ($i=0 ; $i<count($upload_file_title) ; $i++){
//                $ft = $upload_file_title[$i]; //->getClientOriginalName();
//                array_push($rules, [$ft =>'max:255']);
//            }
//        }

        return Validator::make($request, $rules);
    }









    //--------------------------------------------------------------------//
    // PART 2 : insert into DB benefiter medical tables
    //--------------------------------------------------------------------//
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
        // medication table
        $this->save_medical_medication($request, $medicalVisit_id);
        // medical referrals
        $this->save_medical_referrals($request, $medicalVisit_id);
        // medical file uploads
        $this->save_medical_uploads($request, $medicalVisit_id);
    }

    //----------- medical_visit table ------------------------------------DONE//
    private function create_medical_visit($request){
        $newMedicalVisit = new medical_visits();
        $newMedicalVisit->benefiter_id = $request['benefiter_id'];
        $newMedicalVisit->doctor_id = $request['doctor_id'];
        $newMedicalVisit->medical_location_id = $request['medical_location_id'];
        $newMedicalVisit->medical_incident_id = $request['medical_incident_id'];
        $newMedicalVisit->medical_visit_date = $this->datesHelper->makeDBFriendlyDate($request['examination_date']);
        $newMedicalVisit->save();
        return $newMedicalVisit->id;
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

    //----------- clinical_examination_results table ----------------------DONE//
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

    //----------- medical_examinations table ----------------------------DONE//
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

    //----------- medical_laboratory_results table ----------------------DONE//
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
                if (empty($request_medication_new_name[$i])) {
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
                    $med_medication->medical_visit_id = $id;
                    $med_medication->medication_lookup_id = $med_medication_lookup->id;

                    $med_medication->save();
                }
            }
        }
    }

    //----------- medical_referrals table ---------------------------DONE//
    // DB save
    private function save_medical_referrals($request, $id){
        $request_medical_referrals = $this->medical_referrals($request);
        foreach($request_medical_referrals as $rmr){
            if(!empty($rmr)){
                $med_referral = new medical_referrals();
                $med_referral->referrals = $rmr;
                $med_referral->medical_visit_id = $id;
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

    //----------- medical_uploads table ----------------------------//
    // DB save
    private function save_medical_uploads($request, $id){
        $request_upload_file_description = $request['upload_file_description'];
        $request_upload_file_title = $request['upload_file_title'];

        $file = Input::file('upload_file_title');

        $files_numbers = count($request_upload_file_title);
        for ($i = 0; $i < $files_numbers; $i++) {
            if(!empty($file[$i])){

                $path = base_path() . '/public/uploads/medical-visit-uploads/';
                $fileName = 'medical_visit-' . $id . $file[$i]->getClientOriginalName();
                $file[$i]->move($path, $fileName); // uploading file to given path
                $medical_upload = new medical_uploads();
                $medical_upload->title = $fileName;
                $medical_upload->description = $request_upload_file_description[$i];
                $medical_upload->path = $path;
                $medical_upload->medical_visit_id = $id;

                $medical_upload->save();
            }
        }
    }











    // ------------------------------------------------------------------ //
    // PART 3 : EDIT SAVED MEDICAL VISIT
    //--------------------------------------------------------------------//


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
        // medication table
        $this->update_medical_medication($request, $updatedMedicalVisit_id);
        // medical referrals
        $this->update_medical_referrals($request, $updatedMedicalVisit_id);
        // medical file uploads
        $this->upload_medical_uploads($request, $updatedMedicalVisit_id);

    }

    //----------- medical_visit table ------------------------------------DONE//
    private function update_medical_visit($request, $selected_medical_visit_id){
        $updateddMedicalVisit = medical_visits::find($selected_medical_visit_id);

        $updateddMedicalVisit->benefiter_id = $request['benefiter_id'];
        $updateddMedicalVisit->doctor_id = $request['doctor_id'];
        $updateddMedicalVisit->medical_location_id = $request['medical_location_id'];
        $updateddMedicalVisit->medical_incident_id = $request['medical_incident_id'];
        $updateddMedicalVisit->medical_visit_date = $this->datesHelper->makeDBFriendlyDate($request['examination_date']);
        $updateddMedicalVisit->save();
        return $updateddMedicalVisit->id;
    }

    //----------- medical_chronic_conditions table -----------------------DONE//
    // DB save
    private function update_medical_chronic_conditions($request, $selected_medical_visit_id){
        $request_medical_chronic_conditions = $this->get_updated_chronic_conditions($request);
        $requests_count = count($request_medical_chronic_conditions);
        $saved_medical_chronic_conditions = medical_chronic_conditions::where("medical_visit_id", $selected_medical_visit_id)->get();
        $saved_count = count($saved_medical_chronic_conditions);
        $counter = 0;

        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_count){
            for($i=0; $i<$requests_count ; $i++) {
                if ($counter < $saved_count) {
                    if(!empty($request_medical_chronic_conditions[$i])){
                        $medical_chronic_condition = medical_chronic_conditions::find($saved_medical_chronic_conditions[$counter]['id']);
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
                        $medical_chronic_condition = medical_chronic_conditions::find($saved_medical_chronic_conditions[$counter]['id']);
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
                    $medical_chronic_condition = medical_chronic_conditions::find($saved_medical_chronic_conditions[$counter]['id']);
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

    //----------- clinical_examination_results table ----------------------DONE//
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
            $saved_examinations_with_same_clinical_result= medical_examination_results::where("medical_visit_id", $selected_medical_visit_id)
                                                                                ->where("results_lookup_id", $this->find_medical_examination_results_lookup_id($i+1))->get();
            $counter = 0;
            // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
            if($requests_icd10_count > count($saved_examinations_with_same_clinical_result)){
                if(!empty($request_med_exams_results[$i])) {
                    // for every icd10 condition
                    for ($j = 0; $j < count($request_med_exams_results[$i]); $j++) {
                        if (!empty($request_med_exams_results[$i][$j])) {
                            // update what is saved
                            if($counter < count($saved_examinations_with_same_clinical_result)){
                                $medical_examination_result = medical_examination_results::find($saved_examinations_with_same_clinical_result[$counter]['id']);
                                $medical_examination_result->description = $request_med_exams_description[$i];
                                $medical_examination_result->icd10_id = $request_med_exams_results[$i][$j];
                                $medical_examination_result->medical_visit_id = $selected_medical_visit_id;
                                $med_exams_lookup_item = $this->find_medical_examination_results_lookup_id($i+1);
                                $medical_examination_result->results_lookup_id = $med_exams_lookup_item;

                                $medical_examination_result->save();
                            //add new rows for the new requests
                            }else{
                                $medical_examination_results = new medical_examination_results();
                                $medical_examination_results->description = $request_med_exams_description[$i];
                                $medical_examination_results->icd10_id = $request_med_exams_results[$i][$j];
                                $medical_examination_results->medical_visit_id = $selected_medical_visit_id;
                                // get medical examinations list from the lookup table
                                $med_exams_lookup_item = $this->find_medical_examination_results_lookup_id($i+1);
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
                            $medical_examination_result = medical_examination_results::find($saved_examinations_with_same_clinical_result[$counter]['id']);
                            $medical_examination_result->description = $request_med_exams_description[$i];
                            $medical_examination_result->icd10_id = $request_med_exams_results[$i][$j];
                            $medical_examination_result->medical_visit_id = $selected_medical_visit_id;
                            // get medical examinations list from the lookup table
                            $med_exams_lookup_item = $this->find_medical_examination_results_lookup_id($i+1);
                            $medical_examination_result->results_lookup_id = $med_exams_lookup_item;

                            $medical_examination_result->save();
                        }
                    // else delete extra rows
                    } else {
                        $medical_examination_result = medical_examination_results::find($saved_examinations_with_same_clinical_result[$counter]['id']);
                        $medical_examination_result->delete();
                    }
                    $counter++;
                }
            }
        } // end for every clinical result
    }

    //----------- medical_examinations table ----------------------------DONE//
    // DB save
    private function update_medical_examinations($request, $selected_medical_visit_id){
        $medical_examination = medical_examinations::where("medical_visit_id", $selected_medical_visit_id)->first();
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

    //----------- medical_laboratory_results table ----------------------DONE//
    // DB save
    private function update_medical_laboratory_results($request, $selected_medical_visit_id){
        $request_lab_results = $this->update_laboratory_results($request);
        $requests_count = count($request_lab_results);
        $saved_lab_results = medical_laboratory_results::where("medical_visit_id", $selected_medical_visit_id)->get();
        $saved_lab_results_count = count($saved_lab_results);
        $counter = 0;
        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_lab_results_count){
            for($i=0; $i<$requests_count ; $i++) {
                // update what is saved
                if ($counter < $saved_lab_results_count) {
                    if(!empty($request_lab_results[$i])){
                        $lab_result = medical_laboratory_results::find($saved_lab_results[$counter]['id']);
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
                        $lab_result = medical_laboratory_results::find($saved_lab_results[$counter]['id']);
                        $lab_result->laboratory_results = $request_lab_results[$j];
                        $lab_result->medical_visit_id = $selected_medical_visit_id;
                        $lab_result->save();
                    }
                    // else delete extra rows
                } else {
                    $lab_result = medical_laboratory_results::find($saved_lab_results[$counter]['id']);
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

    //----------- medical_medication table ----------------------------DONE//
    // DB save
    private function update_medical_medication($request, $selected_medical_visit_id){
//        dd($request);
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
        $saved_medication = medical_medication::where("medical_visit_id", $selected_medical_visit_id)->get();
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
                        $med_medication = medical_medication::find($saved_medication[$counter]['id']);
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
                        $med_medication = medical_medication::find($saved_medication[$counter]['id']);
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
                    $med_medication = medical_medication::find($saved_medication[$counter]['id']);
                    $med_medication->delete();
                }
                $counter++;
            }
        }




        // if new elements added
//        for($i=0; $i<$request_medication_Number ; $i++){
//            // Medicinal condition DB entry (save to DB only if all fields are filled)
//            if(!empty($request_medication_dosage[$i]) && !empty($request_medication_duration[$i])) {
//                $med_medication = new medical_medication();
//                // check if the request comes from the auto complete select (from lookup)
//                if (empty($request_medication_new_name[$i])) {
//                    $request_medication_name[$i] = $request_medication_name_from_lookup[$i];
//                    $med_medication->dosage = $request_medication_dosage[$i];
//                    $med_medication->duration = $request_medication_duration[$i];
//                    if(!empty($request_supply_from_praksis)){
//                        $med_medication->supply_from_praksis = $request_supply_from_praksis[$i];
//                    }else{
//                        $med_medication->supply_from_praksis = 0;
//                    }
//                    $med_medication->medical_visit_id = $selected_medical_visit_id;
//                    $med_medication->medication_lookup_id = $request_medication_name[$i];
//                    $med_medication->save();
//                }
//                // check if the request comes from the input field.
//                else{
//                    $request_medication_name[$i] = $request_medication_new_name[$i];
//                    $med_medication_lookup = new medical_medication_lookup();
//                    $med_medication_lookup->description = $request_medication_name[$i];
//                    $med_medication_lookup->save();
//
//                    // then continue to medication table
//                    $med_medication->dosage = $request_medication_dosage[$i];
//                    $med_medication->duration = $request_medication_duration[$i];
//                    if(!empty($request_supply_from_praksis)){
//                        $med_medication->supply_from_praksis = $request_supply_from_praksis[$i];
//                    }else{
//                        $med_medication->supply_from_praksis = 0;
//                    }
//                    $med_medication->medical_visit_id = $selected_medical_visit_id;
//                    $med_medication->medication_lookup_id = $med_medication_lookup->id;
//                    $med_medication->save();
//                }
//            }
//        }
    }

    //----------- medical_referrals table ---------------------------DONE//
    // DB save
    private function update_medical_referrals($request, $selected_medical_visit_id){
        $request_medical_referrals = $this->update_requested_medical_referrals($request);
        $requests_count = count($request_medical_referrals);
        $saved_medical_referrals = medical_referrals::where("medical_visit_id", $selected_medical_visit_id)->get();
        $saved_medical_referrals_count = count($saved_medical_referrals);
        $counter = 0;

        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_medical_referrals_count){
            for($i=0; $i<$requests_count ; $i++) {
                if ($counter < $saved_medical_referrals_count) {
                    if(!empty($request_medical_referrals[$i])){
                        $med_referral = medical_referrals::find($saved_medical_referrals[$counter]['id']);
                        $med_referral->referrals = $request_medical_referrals[$i];
                        $med_referral->medical_visit_id = $selected_medical_visit_id;
                        $med_referral->save();
                    }
                } else {
                    if(!empty($request_medical_referrals[$i])){
                        $med_referral = new medical_referrals();
                        $med_referral->referrals = $request_medical_referrals[$i];
                        $med_referral->medical_visit_id = $selected_medical_visit_id;
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
                        $med_referral = medical_referrals::find($saved_medical_referrals[$counter]['id']);
                        $med_referral->referrals = $request_medical_referrals[$j];
                        $med_referral->medical_visit_id = $selected_medical_visit_id;
                        $med_referral->save();
                    }
                } else {
                    $med_referral = medical_referrals::find($saved_medical_referrals[$counter]['id']);
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

    //----------- medical_uploads table ----------------------------//
    // DB save
    private function upload_medical_uploads($request, $selected_medical_visit_id){
        $path = base_path() . '/public/uploads/medical-visit-uploads/';
        $request_upload_file_description = $request['upload_file_description'];
        $request_upload_file_title = $request['upload_file_title'];
        $file = Input::file('upload_file_title');
        $requests_count = count($request_upload_file_title);

        $saved_files = medical_uploads::where("medical_visit_id", $selected_medical_visit_id)->get();
        $saved_files_count = count($saved_files);
        $counter = 0;

        // if the request array is bigger than the saved then update what is saved and then add new rows for the new requests
        if($requests_count > $saved_files_count){
            for($i=0; $i<$requests_count ; $i++) {
                if ($counter < $saved_files_count) {
                    if(!empty($file[$i])){
                        $fileName = 'medical_visit-' . $selected_medical_visit_id . $file[$i]->getClientOriginalName();
                        $file[$i]->move($path, $fileName); // uploading file to given path
                        $medical_upload = medical_uploads::find($saved_files[$counter]['id']);
                        $medical_upload->title = $fileName;
                        $medical_upload->description = $request_upload_file_description[$i];
                        $medical_upload->path = $path;
                        $medical_upload->medical_visit_id = $selected_medical_visit_id;
                        $medical_upload->save();
                    }
                } else {
                    if(!empty($request_medical_referrals[$i])){
                        $fileName = $file[$i]->getClientOriginalName() . '-medical_visit-' . $selected_medical_visit_id;
                        $file[$i]->move($path, $fileName); // uploading file to given path
                        $medical_upload = new medical_uploads();
                        $medical_upload->title = $fileName;
                        $medical_upload->description = $request_upload_file_description[$i];
                        $medical_upload->path = $path;
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
                    if(!empty($file[$j])){
                        $fileName = 'medical_visit-' . $selected_medical_visit_id . $file[$j]->getClientOriginalName();
                        $file[$j]->move($path, $fileName); // uploading file to given path
                        $medical_upload = medical_uploads::find($saved_files[$counter]['id']);
                        $medical_upload->title = $fileName;
                        $medical_upload->description = $request_upload_file_description[$j];
                        $medical_upload->path = $path;
                        $medical_upload->medical_visit_id = $selected_medical_visit_id;
                        $medical_upload->save();
                    }
                } else {
                    $medical_upload = medical_uploads::find($saved_files[$counter]['id']);
                    $medical_upload->delete();
                }
                $counter++;
            }
        }

//        for ($i = 0; $i < $requests_count; $i++) {
//            if(!empty($file[$i])){
//                $path = base_path() . '/public/uploads/medical-visit-uploads/';
//                $fileName = $file[$i]->getClientOriginalName() . '-medical_visit-' . $selected_medical_visit_id;
//                $file[$i]->move($path, $fileName); // uploading file to given path
//
//                $medical_upload = new medical_uploads();
//                $medical_upload->title = $fileName;
//                $medical_upload->description = $request_upload_file_description[$i];
//                $medical_upload->path = $path;
//                $medical_upload->medical_visit_id = $selected_medical_visit_id;
//
//                $medical_upload->save();
//            }
//        }
    }


    // ------------------------------------------------------------------ //
    // PART 3 : END
    //--------------------------------------------------------------------//




    // FUNCTIONS USED BY MANY

    public function reindex_array($array){
        $reindexed_array = [];
        for($i=0 ; $i<count($array) ; $i++){
            $reindexed_array[$i+1] = $array[$i]->description;
        }
        return $reindexed_array;
    }

    // keeps every element and reindex only the array from 1 to n
    public function general_reindex_array($array){
        $reindexed_array = [];
        for($i=0 ; $i<count($array) ; $i++){
            $reindexed_array[$i+1] = $array[$i];
        }
        return $reindexed_array;
    }
    // medical visits for each benefiter
    public function findMedicalVisitsForBenefiter($id){
        return medical_visits::where('benefiter_id', $id)->with('doctor', 'medicalLocation', 'medicalIncidentType')->get();
    }
    // chronic conditions for each benefiter
    public function findMedicalChronicConditionsForBenefiter($benefiter_id, $medical_visit_id){
        return medical_chronic_conditions::where('benefiters_id', $benefiter_id)->where('medical_visit_id', $medical_visit_id)->with('chronic_conditions_lookup')->get();;
    }
    // number of medical visits foreach benefiter
    public function benefiter_medical_visits_number($id){
        $medical_visits_number = medical_visits::where('benefiter_id', $id)->count();
        return $medical_visits_number;
    }
    // examination results
    public function examinationsResultsLookup(){
        $examResultsLookup = medical_examination_results_lookup::get()->all();
        return $examResultsLookup;
    }
    // Medical Visit location
    public function medicalLocationsLookup(){
        $medical_locations = medical_location_lookup::get();
        return $medical_locations;
    }
    // Incident type
    public function medicalIncidentTypeLookup(){
        $medical_incident_type = medical_incident_type_lookup::get();
        return $medical_incident_type;
    }
    // doctor id
    public function findDoctorId(){
        $doctor_id = Auth::user()->id;
        return $doctor_id;
    }
    // physical examinations
    public function findMedicalVisitExamination($med_visit_id){
        $med_visit_examination = medical_examinations::where('medical_visit_id', $med_visit_id)->first();
        return $med_visit_examination;
    }
    // Examination results
    public function findMedicalVisitExaminationResults($med_visit_id){
        $med_visit_exam_results = medical_examination_results::where('medical_visit_id', $med_visit_id)->with('icd10')->get();
        return $med_visit_exam_results;
    }

    public function find_medical_examination_results_lookup_id($id){
        $medical_examination_results_lookup_id = medical_examination_results_lookup::where('id', '=', $id)->first()['attributes']['id'];
        return $medical_examination_results_lookup_id;
    }
    // Lab results
    public function findMedicalVisitLabResults($med_visit_id){
        $med_visit_lab_results = medical_laboratory_results::where('medical_visit_id', $med_visit_id)->get();
        return $med_visit_lab_results;
    }
    // Medication
    public function findMedicalVisitMedication($med_visit_id){
        $med_visit_medication = medical_medication::where('medical_visit_id', $med_visit_id)->with('medical_medication_lookup')->get();
        return $med_visit_medication;
    }
    // Referrals
    public function findMedicalVisitReferrals($med_visit_id){
        $med_visit_referrals = medical_referrals::where('medical_visit_id', $med_visit_id)->get();
        return $med_visit_referrals;
    }
    // Uploads
    public function findMedicalVisitUploads($med_visit_id){
        $med_visit_uploads = medical_uploads::where('medical_visit_id', $med_visit_id)->get();
        return $med_visit_uploads;
    }
    // find name of ICD10 list by id
    public function getICD10By_id($id){
        $description = ICD10::where('id', '=', $id)->first()->description;
        $code = ICD10::where('id', '=', $id)->first()->code;
        $result = $code .': '. $description;
        return $result;
    }
    // find medication name by id
    public function getMedicationLookupBy_id($id){
        $medicine_name = medical_medication_lookup::where('id', '=', $id)->first()->description;
        return $medicine_name;
    }
    // return all the medical locations
    public function getAllMedicalLocations(){
        return medical_location_lookup::get()->all();
    }

}
