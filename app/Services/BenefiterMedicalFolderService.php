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
use App\Models\Benefiters_Tables_Models\ICD10;
use App\Models\Benefiters_Tables_Models\medical_location_lookup;
use App\Services\DatesHelper;
use Illuminate\Support\Facades\Input;
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



    // ------------------------------------------------------------------ //
    //----------- medical_examination_results table ----------------------DONE//
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


    // ----------------------------------------------------------------- //
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



    // ----------------------------------------------------------------- //
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
    // other lookup tables



    // --------------------------------------------------------------- //
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


    // -------------------------------------------------------------- //
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



    // ------------------------------------------------------------ //
    //----------- medical_uploads table ----------------------------//
    // DB save
    private function save_medical_uploads($request, $id){
        $request_upload_file_description = $request['upload_file_description'];
        $request_upload_file_title = $request['upload_file_title'];

        $file = Input::file('upload_file_title');
        $files_numbers = count($request_upload_file_title);
        for ($i = 0; $i < $files_numbers; $i++) {
            while(!empty($file[$i])){
                $path = public_path() . '/uploads/medical-visit-uploads';
                $fileName = $file[$i]->getClientOriginalName() . '-medical_visit-' . $id;
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
    // PART 2 : END
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

    public function getICD10By_id($id){
        $description = ICD10::where('id', '=', $id)->first()->description;
        $code = ICD10::where('id', '=', $id)->first()->code;
        $result = $code .': '. $description;
        return $result;
    }

    public function getMedicationLookupBy_id($id){
        $medicine_name = medical_medication_lookup::where('id', '=', $id)->first()->description;
        return $medicine_name;
    }


    // return all the medical locations
    public function getAllMedicalLocations(){
        return medical_location_lookup::get()->all();
    }

}
