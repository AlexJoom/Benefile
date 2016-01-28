<?php

namespace AppModels\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class Work_status_lookup extends Model
{
    protected $table = 'work_status_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['work_status'];
}
