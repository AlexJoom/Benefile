<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_chronic_conditions_lookup extends Model
{
    protected $table = 'medical_chronic_conditions_lookup';
    protected $fillable = ['description'];
}
