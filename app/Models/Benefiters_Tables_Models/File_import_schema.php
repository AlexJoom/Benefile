<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class File_import_schema extends Model
{
    protected $table = 'File_Import_Schema';
    protected $primaryKey = 'id';
    protected $fillable = [
        'folder_number',
        'name',
        'lastname',
        'fathers_name',
        'mothers_name',
        'gender',
        'origin_country',
        'nationality_country',
        'birth_date',
        'arrival_date',
        'address',
        'telephone',
        'marital_status',
        'number_of_children',
        'relatives_residence',
        'legal_status',
//        'legal_status_details',             // ??? not shown on excel
//        'legal_status_exp_date',            // ??? not shown on excel
        'education',
        'language',
        'language_level',
//        'language_interpreter_needed',      // ???? not shown on excel
//        'other_language',                   // ???? not shown on excel
        'is_benefiter_working',
        'work_title',
        'working_legally',
        'country_abandon_reason',
        'travel_route',
        'travel_duration',
        'detention_duration',

//        'social_reference',                 // ???? not shown on excel
//        'social_reference_actions',         // ???? not shown on excel
//        'social_reference_date',            // ???? not shown on excel
//
//        'has_medical_reference',            // ???? not shown on excel
//        'medical_reference_actions',        // ???? not shown on excel
//        'medical_reference_date',           // ???? not shown on excel
//
//        'has_legal_reference',              // ???? not shown on excel
//        'legal_reference_actions',          // ???? not shown on excel
//        'legal_reference_date',             // ???? not shown on excel
//
//        'has_educational_reference',        // ???? not shown on excel
//        'educational_reference_actions',    // ???? not shown on excel
//        'educational_reference_date',       // ???? not shown on excel
//
//        'social_history'                    // ???? not shown on excel
    ];
}
