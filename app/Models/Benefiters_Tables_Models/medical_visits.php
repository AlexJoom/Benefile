<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_visits extends Model
{
    protected $table = 'medical_visits';
    protected $fillable = ['medical_visit_date'];


    public function benefiter(){
        return $this->hasOne('App\Models\Benefiters_Tables_Models\Benefiter','id', 'benefiter_id');
    }

    public function doctor(){
        return $this->hasOne('App\Models\User', 'id', 'doctor_id');
    }

    public function medicalLocation()
    {
        return $this->hasOne('App\Models\Benefiters_Tables_Models\medical_location_lookup', 'id', 'medical_location_id');
    }

}
