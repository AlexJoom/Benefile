<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class Legal_status_lookup extends Model
{
    protected $table = 'legal_status_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['legal_status_title'];
}
