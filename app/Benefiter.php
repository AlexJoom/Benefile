<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Benefiter extends Model{

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
            'other_language',
            'work_type_id',
            'work_status_id',
            'country_abandon_reason',
            'travel_route',
            'travel_duration',
            'detention_duration',

            'social_reference_id',
            'social_reference_actions',
            'social_reference_date',

            'medical_reference_id',
            'medical_reference_actions',
            'medical_reference_date',

            'legal_reference_id',
            'legal_reference_actions',
            'legal_reference_date',

            'educational_reference_id',
            'educational_reference_actions',
            'educational_reference_date',

            'social_history'
    ];
}
