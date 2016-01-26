<?php

namespace AppModels\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class Reference_lookup extends Model
{
    protected $table = 'reference_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['booleanIndicator'];
}
