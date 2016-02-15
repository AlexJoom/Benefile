<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_visits extends Model
{
    protected $table = 'medical_visits';

    protected $fillable = [
        'has_medical_reference',
        'medical_reference_actions',
        'medical_reference_date'];

    public function benefiter()
    {
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\Benefiter', 'benefiters_id');
    }

    public function medical_laboratory_results()
    {
        return $this->hasMany('App\Models\Benefiters_Tables_Models\medical_visits');
    }

    public function medical_chronic_conditions()
    {
        return $this->hasMany('App\Models\Benefiters_Tables_Models\medical_chronic_conditions');
    }

    public function medical_medication()
    {
        return $this->hasMany('App\Models\Benefiters_Tables_Models\medical_medication');
    }

    public function medical_examination_results()
    {
        return $this->hasMany('App\Models\Benefiters_Tables_Models\medical_examination_results');
    }

    public function medical_referrals()
    {
        return $this->hasMany('App\Models\Benefiters_Tables_Models\medical_referrals');
    }
}
