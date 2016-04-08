<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class benefiterOccurrences extends Model{

    protected $table = 'benefiter_occurrences';

    protected $fillable = [
        'description',
        'occurrence_date',
        'benefiter_id',
        'user_id'];

    public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}

