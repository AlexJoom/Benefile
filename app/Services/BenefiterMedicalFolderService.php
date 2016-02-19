<?php namespace app\Services;

use App\Models\Benefiters_Tables_Models\medical_chronic_conditions;
use App\Models\Benefiters_Tables_Models\medical_chronic_conditions_lookup;
use App\Models\Benefiters_Tables_Models\medical_examination_results;
use App\Models\Benefiters_Tables_Models\medical_visits;
use App\Models\Benefiters_Tables_Models\medical_examination_results_lookup;
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
            "social_background" => $request['social_background'],
            "document_manager_id" => \Auth::user()->id,
        );
    }

    //--------------------------------------------------------------------//
    // PART 2 : insert into DB benefiter medical tables
    //--------------------------------------------------------------------//
    // TODO add transaction to public function
    //TODO CREATE A FUNCTION THAT CALLS THE BELOW FUNCTIONS AND MEKE THE BELOW PRIVATE NOT PUBLIC
    //----------- medical_visit table ------------------------------------//
    public function save_medical_visit($request){
        $newMedicalVisit = medical_visits::with('benefiter', 'doctor', 'medicalLocation')->get();
        $newMedicalVisit->benefiter_id = $request['benefiter_id'];
        $newMedicalVisit->doctor_id = $request['doctor_id'];
        $newMedicalVisit->medical_location_id = $request['medical_location_id'];
        $newMedicalVisit->save();
        return $newMedicalVisit->id;
    }

    //----------- medical_chronic_conditions table -----------------------//
    // DB save
    public function save_medical_chronic_conditions($request){
        $medical_chronic_conditions_from_post = $this->get_medical_chronic_conditions($request);
        foreach($medical_chronic_conditions_from_post as $cc){
            $medical_chronic_conditions = new medical_chronic_conditions();
            // save to lookup first
            $medical_chronic_conditions_lookup = new medical_chronic_conditions_lookup();
            $medical_chronic_conditions_lookup->description = $cc;
            $medical_chronic_conditions_lookup->save();
            // then to chronic conditions table
            $medical_chronic_conditions->benefiters_id = 1;
            $medical_chronic_conditions->description = $cc;
            $medical_chronic_conditions->chronic_condition_id = $medical_chronic_conditions_lookup->id;
            $medical_chronic_conditions->save();
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

    //----------- medical_examination_results table ----------------------//
    // DB save
    public function save_medical_examination_results($request, $id){
        $request_medical_examination_results_from_post = $this->get_medical_examination_results($request);
        foreach($request_medical_examination_results_from_post as $exResults){
            $medical_examination_results = new medical_examination_results();

            $medical_examination_results->description = $exResults;
            $medical_examination_results->medical_visit_id = $id;

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
    // other lookup tables

    // ----------------------------------------------------------------- //

    //----------- medical_examinations table ----------------------------//
    // DB save
    public function save_medical_examinations(){

    }
    // post request
    private function medical_examinations($request){
        return array(
            'height' => $request['height'],
            'weight' => $request['weight'],
            'temperature' => $request['temperature'],
            'blood_pressure_systolic' => $request['blood_pressure_systolic'],
            'blood_pressure_diastolic' => $request['blood_pressure_diastolic'],
            'skull-perimeter' => $request['skull-perimeter'],
        );
    }
    // other lookup tables

    // ----------------------------------------------------------------- //

    //----------- medical_laboratory_results table ----------------------//
    // DB save
    public function save_medical_laboratory_results(){

    }
    // post request
    private function medical_laboratory_results($request){
        $lab_results = $request->get('lab-results');
        $lab_results_array = [];
        foreach ($lab_results as $lr){
            array_push($lab_results_array, $lr);
        }
        return $lab_results_array;
    }
    // other lookup tables

    // --------------------------------------------------------------- //


    //----------- medical_medication table ----------------------------//
    // DB save
    public function save_medical_medication(){

    }
    //post request
    private function medical_medication($request){
        $medicationList = $request->get('medicationList');
        $medication_array =[];
        foreach ($medicationList as $ml){
            array_push($medication_array, $ml);
        }
        return$medication_array;
    }
    // other lookup tables

    // -------------------------------------------------------------- //



    //----------- medical_referrals table ---------------------------//
    // DB save
    public function save_medical_referrals(){

    }
    // post request
    private function medical_referrals($request){
        $referrals = $request->get('referrals');
        $referrals_array = [];
        foreach ($referrals as $ref){
            array_push($referrals_array, $ref);
        }
        return $referrals_array;
    }
    // other lookup tables

    // ------------------------------------------------------------ //



    //----------- medical_uploads table ----------------------------//
    // DB save
    public function save_medical_uploads(){

    }
    // post request
    private function medical_uploads($request){

    }
    // other lookup tables

    // ------------------------------------------------------------------ //
    // PART 2 : END
    //--------------------------------------------------------------------//

    // FUNCTIONS USED BY MANY
    /*
     * will return the medical visit id from the
     */
    private function get_medical_visit_id($id){

    }

}