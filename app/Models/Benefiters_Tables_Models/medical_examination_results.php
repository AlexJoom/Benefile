<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_examination_results extends Model
{
    protected $table = 'medical_examination_results';

    public function medical_visits()
    {
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\medical_visits', 'medical_visit_id');
    }

    public function medical_examination_results()
    {
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\medical_examination_results_lookup');
    }
}
