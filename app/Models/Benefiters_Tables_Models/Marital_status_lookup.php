<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class Marital_status_lookup extends Model
{
    protected $table = 'marital_status_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['marital_status_title'];
}
