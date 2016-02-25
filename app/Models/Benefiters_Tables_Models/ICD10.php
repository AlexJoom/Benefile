<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class ICD10 extends Model
{
    protected $table = 'icd10';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'description'];
}
