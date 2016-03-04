<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_incident_type_lookup extends Model
{
    protected $table = 'medical_incident_type_lookup';

    protected $fillable = ['description'];
}
