<?php

namespace App\Http\Controllers;



use App\Benefiter;
use Requests;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class UploadFileController extends Controller{

    public function excelUpload(){
        // get the file from the post request
        $file = Input::file('file');
        // set file name
        $filename =Carbon::now('Europe/Athens') .'-' . $file->getClientOriginalName();
        // move file to correct location
        $file->move('../uploadedExcels', $filename);
        $filePath = '/uploadedExcels/'. $filename;

        return $this->excelImport($filePath);
    }

    public function excelImport(){
        header('Content-Type: text/html; charset=UTF-8');
        // Call benefiter table in db
        $benefiters = new Benefiter();
        $benefiterFieldsArray = [
            'folder_number', 'name', 'lastname', 'fathers_name', 'mothers_name', 'gender_id', 'origin_country_id',
            'nationality_country_id', 'birth_date', 'arrival_date', 'address', 'telephone', 'marital_status_id',
            'number_of_children', 'relatives_residence', 'legal_status_id', 'legal_status_details', 'legal_status_exp_date',
            'education_id', 'language_id', 'language_level_id', 'other_language', 'work_type_id', 'work_status_id',
            'country_abandon_reason', 'travel_route', 'travel_duration', 'detention_duration', 'social_reference_id',
            'social_reference_actions', 'social_reference_date', 'medical_reference_id', 'medical_reference_actions',
            'medical_reference_date', 'legal_reference_id', 'legal_reference_actions', 'legal_reference_date',
            'educational_reference_id', 'educational_reference_actions', 'educational_reference_date', 'social_history'
        ];

//        var_dump(count($benefiterFieldsArray));

        // Import csv
        $filePath = "/uploadedExcels/2016-01-21 15:11:42-ΠΑΡΑΡΤΗΜΑ_2-ΚΑΤΑΓΡΑΦΗ_ΔΕΔΟΜΕΝΩΝ.csv";
        $csvFile = file(base_path() . $filePath);

        // Iterate between all rows of the csv file and add each value to the benefiters table
        for($i=1; $i<count($csvFile); $i++) {
            $colValues = str_getcsv( $csvFile[$i]);

            // folder_number
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // name
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // lastname
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // fathers_name
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // mothers_name
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // gender_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // origin_country_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // nationality_country_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // birth_date
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // arrival_date
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // address
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // telephone
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // marital_status_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // number_of_children
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // relatives_residence
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // legal_status_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // legal_status_details
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // legal_status_exp_date
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // education_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // language_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // language_level_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // other_language
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // work_type_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // work_status_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // country_abandon_reason
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // travel_route
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // travel_duration
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // detention_duration
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // social_reference_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // social_reference_actions
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // social_reference_date
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // medical_reference_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // medical_reference_actions
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // medical_reference_date
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // legal_reference_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // legal_reference_actions
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // legal_reference_date
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // educational_reference_id
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // educational_reference_actions
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // educational_reference_date
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];
            // social_history
            $benefiters->$benefiterFieldsArray[0] = $colValues[1];

        }

    }

}
