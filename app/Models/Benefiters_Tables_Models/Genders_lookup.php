<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class Genders_lookup extends Model
{
    protected $table = 'genders_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['gender'];

    public function benefiter() {
        return $this->belongsToMany('App\Models\Benefiter');
    }
}
