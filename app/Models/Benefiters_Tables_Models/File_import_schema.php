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
        'legal_status_details',
        'legal_status_exp_date',
        'education',
        'language',
        'language_level',
        'language_interpreter_needed',
        'other_language',
        'is_benefiter_working',
        'work_title',
        'working_legally',
        'country_abandon_reason',
        'travel_route',
        'travel_duration',
        'detention_duration',

        'social_reference',
        'social_reference_actions',
        'social_reference_date',

        'has_medical_reference',
        'medical_reference_actions',
        'medical_reference_date',

        'has_legal_reference',
        'legal_reference_actions',
        'legal_reference_date',

        'has_educational_reference',
        'educational_reference_actions',
        'educational_reference_date',

        'social_history'];
}
