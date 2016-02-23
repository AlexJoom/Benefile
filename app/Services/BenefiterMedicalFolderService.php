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
use App\Services\DatesHelper;
use Validator;
use Carbon\Carbon;

class BenefiterMedicalFolderService
{

    private $datesHelper;
    private $requestForValidation;
    private $medical_visit_id = 1;

    public function __construct()
    {
        // initialize dates helper
        $this->datesHelper = new DatesHelper();
    }

    //-----------------------------------------------//
    // PART 1 : validate the medical info frm the post
    //-----------------------------------------------//
    public function medicalValidation($request){
        $this->requestForValidation = $this->getValidationArray($request);
        $rules = array(
            'doctor_name' => 'max:255',
            'examination_date' => 'date',
            'examination_location' => 'integer',
            'incident_type' => 'integer',
            'height' => 'digits:3',
            'weight' => 'digits:3',
            'temperature' => 'number',
            'blood_pressure_systolic' => 'number',
            'blood_pressure_diastolic' => 'number',
            'skull-perimeter' => 'digits:3',
            'respiratory_system' => 'max:2000',
            'digestive_system' => 'max:2000',
            'skin_tissue' => 'max:2000',
            'cardiovascular_system' => 'max:2000',
            'urinary_system' => 'max:2000',
            'musculoskeletal_system' => 'max:2000',
            'immunization_system' => 'max:2000',
            'nervous_system' => 'max:2000',
            'other' => 'max:2000',
        );
        // Push the dynamic elements into the rule array
        $chronic_conditions = $request[('chronic_conditions')];
        foreach ($chronic_conditions as $cc){
            array_push($rules, [$cc=>'max:255']);
        }

        // Push the dynamic elements into the rule array
        $lab_results = $request->get('lab-results');
        foreach ($lab_results as $lr){
            array_push($rules, [$lr=>'max:255']);
        }

        // Push the dynamic elements into the rule array
        $medicationList = $request->get('medicationList');
        foreach ($medicationList as $ml){
            array_push($rules, [$ml=>'max:255']);
        }

        // Push the dynamic elements into the rule array
        $referrals = $request->get('referrals');
        foreach ($referrals as $ref){
            array_push($rules, [$ref=>'max:255']);
        }

        // Push the dynamic elements into the rule array
        $upload_file_title = $request->get('upload_file_title');
        foreach ($upload_file_title as $ft){
            array_push($rules, [$ft=>'max:255']);
        }

        // Push the dynamic elements into the rule array
        $upload_file_path = $request->get('upload_file_path');
        foreach ($upload_file_path as $fp){
            array_push($rules, [$fp=>'max:255']);
        }

        return Validator::make($this->requestForValidation, $rules);
    }

    // returns an array suitable for validation
    private function getValidationArray($request){
        return array(
//            TODO
//            "social_background" => $request['social_background'],
//            "document_manager_id" => \Auth::user()->id,
        );
    }

    //--------------------------------------------------------------------//
    // PART 2 : insert into DB benefiter medical tables
    //--------------------------------------------------------------------//
    // TODO add transaction to public function (not now)



    //TODO CREATE A FUNCTION THAT CALLS THE BELOW FUNCTIONS AND MAKE THE BELOW PRIVATE NOT PUBLIC
    //----------- medical_visit table ------------------------------------DONE//
    public function save_medical_visit($request){
        $newMedicalVisit = new medical_visits();
        $newMedicalVisit->benefiter_id = $request['benefiter_id'];
        $newMedicalVisit->doctor_id = $request['doctor_id'];
        $newMedicalVisit->medical_location_id = $request['medical_location_id'];
        $newMedicalVisit->medical_visit_date = $request['examination_date'];
        $newMedicalVisit->save();
        return $newMedicalVisit->id;
    }



    //----------- medical_chronic_conditions table -----------------------DONE//
    // DB save
    public function save_medical_chronic_conditions($request){
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
    public function save_medical_examination_results($request, $id){
        $request_med_exams_results = $this->get_medical_examination_results($request);
        for($i=0; $i<count($request_med_exams_results) ; $i++){
            if(!empty($request_med_exams_results[$i])){
                $medical_examination_results = new medical_examination_results();

                $medical_examination_results->description = $request_med_exams_results[$i];
                $medical_examination_results->medical_visit_id = $id;
                // get medical examinations list from the lookup table
                $med_exams_lookup_item = medical_examination_results_lookup::where('id', '=', $i+1)->first()['attributes']['id'];
                $medical_examination_results->results_lookup_id = $med_exams_lookup_item;

                $medical_examination_results->save();
            }
        }
    }
    // post request
    private function get_medical_examination_results($request){

        //$count_medical_examination_results_lookup = count(medical_examination_results_lookup::get()->all());
        $request_medical_examination_results_array = [];
        $examResults = $request['examResultLoukup'];
        foreach($examResults as $exam){
            array_push($request_medical_examination_results_array,$exam);
        }
        return $request_medical_examination_results_array;
    }



    // ----------------------------------------------------------------- //
    //----------- medical_examinations table ----------------------------DONE//
    // DB save
    public function save_medical_examinations($request, $id){
        $medical_examination = new medical_examinations();

        $medical_examination->height = $request['height'];
        $medical_examination->weight = $request['weight'];
        $medical_examination->temperature = $request['temperature'];
        $medical_examination->blood_pressure_systolic = $request['blood_pressure_systolic'];
        $medical_examination->blood_pressure_diastolic = $request['blood_pressure_diastolic'];
        $medical_examination->skull_perimeter = $request['skull_perimeter'];
        $medical_examination->examination_date = $request['examination_date'];
        $medical_examination->medical_visit_id = $id;

        $medical_examination->save();
    }



    // ----------------------------------------------------------------- //
    //----------- medical_laboratory_results table ----------------------DONE//
    // DB save
    public function save_medical_laboratory_results($request, $id){
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
    public function save_medical_medication($request, $id){
        $request_medical_medication = $this->medical_medication($request);
        foreach($request_medical_medication as $rmm){
            if(!empty($rmm)){
                $med_medication = new medical_medication();

                // first write to lookup
                $med_medication_lookup = new medical_medication_lookup();
                $med_medication_lookup->description = $rmm;
                $med_medication_lookup->save();

                // then continue to medication table
                $med_medication->medical_visit_id = $id;
                $med_medication->medication_lookup_id = $med_medication_lookup->id;
                $med_medication->save();
            }
        }
    }
    //post request
    private function medical_medication($request){
        $medicationList = $request['medicationList'];
        $medication_array =[];
        foreach ($medicationList as $ml){
            array_push($medication_array, $ml);
        }
        return $medication_array;
    }



    // -------------------------------------------------------------- //
    //----------- medical_referrals table ---------------------------DONE//
    // DB save
    public function save_medical_referrals($request, $id){
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
    public function save_medical_uploads($request){

    }
    // post request
    private function medical_uploads($request){

    }

    // ------------------------------------------------------------------ //
    // PART 2 : END
    //--------------------------------------------------------------------//




    // FUNCTIONS USED BY MANY

    /*
     * will return the medical visit id from the
     */
    private function get_medical_visit_id($id){

    }

    public function reindex_array($array){
        $location_simplier_array = [];
        for($i=0 ; $i<count($array) ; $i++){
            $location_simplier_array[$i+1] = $array[$i]->description;
        }
        return $location_simplier_array;
    }

}
