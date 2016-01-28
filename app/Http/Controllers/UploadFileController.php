<?php

namespace App\Http\Controllers;


use App\Models\Benefiters_Tables_Models\File_import_schema;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;


class UploadFileController extends Controller{

    public function excelUpload(){
        // get the file from the post request
        $file = Input::file('file');
        // set file name
        $filename =Carbon::now('Europe/Athens') .'-' . $file->getClientOriginalName();
        // move file to correct location
        $file->move('../uploadedExcels', $filename);
        $filePath = '/uploadedExcels/'. $filename;

        return $this->fileImport($filePath);
    }

    public function fileImport($filePath){
        header('Content-Type: text/html; charset=UTF-8');
        // Call benefiter table in db
        //
        $file_import_Fields = ['id',
            'folder_number', 'name', 'lastname', 'fathers_name', 'mothers_name', 'gender', 'origin_country',
            'nationality_country', 'birth_date', 'arrival_date', 'address', 'telephone', 'marital_status',
            'number_of_children', 'relatives_residence', 'legal_status', 'legal_status_details', 'legal_status_exp_date',
            'education', 'language', 'language_level', 'other_language', 'language_interpreter_needed', 'is_benefiter_working',
            'work_title', 'working_legally',
            'country_abandon_reason', 'travel_route', 'travel_duration', 'detention_duration', 'has_social_reference',
            'social_reference_actions', 'social_reference_date', 'has_medical_reference', 'medical_reference_actions',
            'medical_reference_date', 'has_legal_reference', 'legal_reference_actions', 'legal_reference_date',
            'has_educational_reference', 'educational_reference_actions', 'educational_reference_date', 'social_history'
        ];

        // Import csv
//        $filePath = "/uploadedExcels/2016-01-22 17:13:25-ΠΑΡΑΡΤΗΜΑ_2-ΚΑΤΑΓΡΑΦΗ_ΔΕΔΟΜΕΝΩΝ.csv";
        $csvFile = file(base_path() . $filePath);
        // Iterate between all rows of the csv file and add each value to the benefiters table
        for($i=1; $i<count($csvFile); $i++) {
            $colValues = str_getcsv( $csvFile[$i]);
            $file_import = new File_import_schema();
            for($j=1; $j<count($colValues); $j++){
               $file_import->$file_import_Fields[$j] = $colValues[$j];
            }
            $file_import->save();
        }
    }

}
