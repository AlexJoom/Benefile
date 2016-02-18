<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class EducationLookup extends Model
{
    protected $table = 'education_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['education_title'];
}
