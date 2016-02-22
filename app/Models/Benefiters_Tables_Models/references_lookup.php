<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class ReferencesLookup extends Model
{
    protected $table = 'benefiter_referrals_lookup';

    protected $fillable = [
        'description'];
}
