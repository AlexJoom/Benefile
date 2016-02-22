<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class ReferencesLookup extends Model
{
    protected $table = 'benefter_reference_lookup';

    protected $fillable = [
        'description'];
}
