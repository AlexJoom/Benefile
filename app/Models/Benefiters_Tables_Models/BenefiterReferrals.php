<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class BenefiterReferrals extends Model
{
    protected $table = 'benefiter_referrals';

    protected $fillable = [
        'description',
        'referral_date',
        'benefiter_id',
        'referral_lookup_id'];
}
