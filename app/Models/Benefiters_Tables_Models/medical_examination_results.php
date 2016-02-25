<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_examination_results extends Model
{
    protected $table = 'medical_examination_results';
    protected $primaryKey = 'id';
    protected $fillable = ['icd10_id'];

    public function medical_visits(){
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\medical_visits','id', 'medical_visit_id');
    }

    public function medical_examination_results_lookup(){
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\medical_examination_results_lookup', 'id', 'results_lookup_id');
    }

    public function icd10(){
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\ICD10', 'id', 'icd10_id');
    }
}
