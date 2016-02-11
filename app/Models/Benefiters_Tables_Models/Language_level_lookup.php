<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class Language_level_lookup extends Model
{
    protected $table = 'language_level_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['language_level'];
}
