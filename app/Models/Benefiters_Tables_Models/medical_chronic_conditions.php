<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_chronic_conditions extends Model
{
    protected $table = 'medical_chronic_conditions';

    protected $fillable = [
        'description',
        'medical_visit_id'];

    public function medical_visits()
    {
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\medical_visits', 'medical_visit_id');
    }
}
