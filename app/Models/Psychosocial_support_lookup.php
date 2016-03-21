<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Psychosocial_support_lookup extends Model
{
    use SoftDeletes;
    protected $table = 'psychosocial_support_lookup';
    protected $dates = ['deleted_at'];
    protected $fillable = ['description'];
}
