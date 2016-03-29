<?php
/**
 * Created by PhpStorm.
 * User: cdimitzas
 * Date: 29/3/2016
 * Time: 12:27 μμ
 */

namespace App\Services\Validation_services\Benefiters\benefiter_medical_folder_services;
use Validator;

class BenefiterMedicalFolderValidationService {
    public function medicalValidationService($request){
        $rules = array(
            'examination_date'         => 'required|date',
            'medical_location_id'      => 'integer',
            'medical_incident_id'      => 'integer',
            'height'                   => 'numeric',
            'weight'                   => 'numeric',
            'temperature'              => 'numeric',
            'blood_pressure_systolic'  => 'numeric',
            'blood_pressure_diastolic' => 'numeric',
            'skull_perimeter'          => 'numeric',
        );
        // VALIDATE - chronic conditions
        $chronic_conditions = $request['chronic_conditions'];
        foreach ($chronic_conditions as $i=>$cc){
            $rules['chronic_conditions.'.$i] = 'max:255';
        }


        // VALIDATE - clinical results
        if(!empty($request['examResultLoukup'])){
            $examResultsDescription = $request['examResultDescription'];
            $examResults = $request['examResultLoukup'];
            for($i=0; $i<count($examResults) ; $i++) {
                if(!empty($examResults[$i]) && !empty($examResultsDescription[$i])){
                    for ($j = 0; $j < count($examResults[$i]); $j++) {
                        if(!empty($examResults[$i][$j])){
                            $rules['examResultDescription.'.$i] = 'max:255';
                            $rules['examResultLoukup.'.$i.'.'.$j] = 'max:255';
                        }
                    }
                }
            }
        }

        // VALIDATE - Lab results
        $lab_results = $request['lab_results'];
        foreach ($lab_results as $i=>$lr){
            $rules['lab_results.'.$i] = 'max:255';
        }

        // VALIDATE - Medication
        $count = 0;
        if(!empty($request['medication_name_from_lookup'])){
            $count = sizeof($request['medication_name_from_lookup']);
        }elseif(!empty($request['medication_dosage'])){
            $count = sizeof($request['medication_dosage']);
        }
        elseif(!empty($request['medication_duration'])){
            $count = sizeof($request['medication_duration']);
        }
        elseif(!empty($request['supply_from_praksis_hidden'])){
            $count = sizeof($request['supply_from_praksis_hidden']);
        }
        if($count>0){
            for($i=0 ; $i<$count ; $i++){
                if(!empty($request['medication_name_from_lookup'])){
                    $rules['medication_name_from_lookup.'.$i] = 'max:255';
                    $rules['medication_new_name.'.$i] = 'max:255';
                }else{
                    $rules['medication_new_name.'.$i] = 'max:255';
                    $rules['medication_name_from_lookup.'.$i] = 'max:255';
                }
                $rules['medication_dosage.'.$i] = 'max:255';
                $rules['medication_duration.'.$i] = 'max:255';
            }
        }

        // VALIDATE - Referrals
        $referrals = $request['referrals'];
        foreach ($referrals as $i=>$ref){
            $rules['referrals.'.$i] = 'max:255';
        }

        // VALIDATE - Uploaded files
        $upload_file_description = $request['upload_file_description'];
        foreach ($upload_file_description as $i=>$fd){
            $rules['upload_file_description.'.$i] = 'max:255';
        }
        return Validator::make($request, $rules);
    }
} 