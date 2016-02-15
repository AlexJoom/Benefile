<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_referrals extends Model
{
    protected $table = 'medical_referrals';

    protected $fillable = [
        'referrals'
        'medical_visit_id'];

    public function medical_visits()
    {
        return $this->belongsTo('App\Models\Benefiters_Tables_Models\medical_visits', 'medical_visit_id');
    }
}
