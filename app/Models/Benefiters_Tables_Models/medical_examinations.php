<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_examinations extends Model
{
    protected $table = 'medical_examinations';

    protected $fillable = [
        'height',
        'weight',
        'skull_perimeter',
        'temperature',
        'blood_pressure',
        'description',
        'medical_visit_id',
        'examination_date'];

    public function medical_visits()
    {
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\medical_visits', 'medical_visit_id');
    }
}
