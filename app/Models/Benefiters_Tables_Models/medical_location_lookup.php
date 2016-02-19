<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_location_lookup extends Model
{
    protected $table = 'medical_location_lookup';

    protected $fillable = ['description'];
}
