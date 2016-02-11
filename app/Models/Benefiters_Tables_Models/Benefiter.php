<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class Benefiter extends Model
{
    protected $table = 'benefiters';
    protected $primaryKey = 'id';
    protected $fillable = [
        'folder_number',
        'name',
        'lastname',
        'fathers_name',
        'mothers_name',
        'gender_id',
        'origin_country_id',
        'nationality_country_id',
        'birth_date',
        'arrival_date',
        'address',
        'telephone',
        'marital_status_id',
        'number_of_children',
        'relatives_residence',
        'legal_status_id',
        'legal_status_details',
        'legal_status_exp_date',
        'education_id',
        'language_id',
        'language_level_id',
        'language_interpreter_needed',
        'other_language',
        'is_benefiter_working',
        'work_title_id',
        'working_legally',
        'country_abandon_reason',
        'travel_route',
        'travel_duration',
        'detention_duration',

        'has_social_reference',
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
