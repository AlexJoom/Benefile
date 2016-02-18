<?php namespace app\Services;

use App\Models\Benefiters_Tables_Models\medical_chronic_conditions;
use App\Models\Benefiters_Tables_Models\medical_examination_results;
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

    // PART 1 : validate the medical info frm the post
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

    // PART 2 : insert into DB benefiter medical table
    public function saveToDB($request){

        // medical_visits table

        // medical_chronic_conditions table

        // medical_examination_results table
        $request_medical_examination_results = $this->medical_examination_results($request);
        $medical_examination_results = new medical_examination_results();

        // medical_examinations table

        // medical_examinations table

        // medical_medication table

        // medical_referrals table

        // medical_uploads table
    }

    //-------------- NEEDED FROM PART 2 ----------------------------//

    // medical_chronic_conditions table
    private function medical_chronic_conditions($request){
        $chronic_conditions = $request['chronic_conditions'];
        $chronic_conditions_array = [];
        foreach ($chronic_conditions as $cc){
            array_push($chronic_conditions_array, ['description'=>$cc]);
        }
        return $chronic_conditions_array;
    }

    // medical_examination_results table
    private function medical_examination_results($request){
        $count_medical_examination_results_lookup = count(medical_examination_results_lookup::get()->all());
        return array(
            'respiratory_system' => $request['respiratory_system'],
            'digestive_system' => $request['digestive_system'],
            'skin_tissue' => $request['skin_tissue'],
            'cardiovascular_system' => $request['cardiovascular_system'],
            'urinary_system' => $request['urinary_system'],
            'musculoskeletal_system' => $request['musculoskeletal_system'],
            'immunization_system' => $request['immunization_system'],
            'nervous_system' => $request['nervous_system'],
            'other' => $request['other'],
        );
    }

    // medical_examinations table
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

    // medical_laboratory_results table
    private function medical_laboratory_results($request){
        $lab_results = $request->get('lab-results');
        $lab_results_array = [];
        foreach ($lab_results as $lr){
            array_push($lab_results_array, $lr);
        }
        return $lab_results_array;
    }

    // medical_medication table
    private function medical_medication($request){
        $medicationList = $request->get('medicationList');
        $medication_array =[];
        foreach ($medicationList as $ml){
            array_push($medication_array, $ml);
        }
        return$medication_array;
    }

    // medical_referrals table
    private function medical_referrals($request){
        $referrals = $request->get('referrals');
        $referrals_array = [];
        foreach ($referrals as $ref){
            array_push($referrals_array, $ref);
        }
        return $referrals_array;
    }

    // medical_uploads table
    private function medical_uploads($request){
//TODO
    }

    // medical_visits table
    private function medical_visits($request){
        return array(
            'doctor_name' =>  $request[\Auth::user()->id],
            'examination_date' => $this->datesHelper->makeDBFriendlyDate($request['examination_date']),
            'examination_location' => $request['examination_location'],
            'incident_type' => $request['incident_type'],
        );
    }

    //-------------- NEEDED FROM PART 2 END ----------------------------//
}