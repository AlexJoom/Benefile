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
        'birth_date',
        'arrival_date',
        'address',
        'telephone',
        'number_of_children',
        'children_names',
        'relatives_residence',
        'other_language',
        'language_interpreter_needed',
        'is_benefiter_working',
        'legal_status_details',
        'working_legally',
        'country_abandon_reason',
        'travel_route',
        'travel_duration',
        'detention_duration',
        'has_educational_reference',
        'educational_reference_actions',
        'educational_reference_date',
        'origin_country',
        'nationality_country',
        'ethnic_group',
        'document_manager_id',
        'social_history',

        'gender_id',
        'marital_status_id',
        'education_id',
        'work_title_id'];

    /*
     * public function benefitersSocialTable()
     * {
     *     return $this->hasOne('App\Models\Benefiters_Tables_Models\BenefitersSocialTable');
     * }
     */

    public function educationLookup()
    {
        return $this->hasOne('App\Models\Benefiters_Tables_Models\EducationLookup', 'id', 'education_id');
    }

    public function medical_visits()
    {
        return $this->hasMany('App\Models\Benefiters_Tables_Models\medical_visits', 'id', 'benefiter_id');
    }
}
