<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_chronic_conditions extends Model
{
    protected $table = 'medical_chronic_conditions';

    protected $fillable = [
        'description'];

    public function chronic_conditions_lookup(){
        return $this->hasMany('App\Models\Benefiters_Tables_Models\medical_visits', 'id', 'chronic_condition_id');
    }

    public function benefiter(){
        return $this->hasOne('App\Models\Benefiters_Tables_Models\Benefiter', 'id', 'benefiters_id');
    }

    public function medical_visits(){
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\medical_visits','id', 'medical_visit_id');
    }
}
