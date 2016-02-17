<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class medical_examination_results_lookup extends Model
{
    protected $table = 'medical_examination_results_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['description'];
}
