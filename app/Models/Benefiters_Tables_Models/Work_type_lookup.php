<?php

namespace AppModels\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class Work_type_lookup extends Model
{
    protected $table = 'work_type_list_lookup';
    protected $primaryKey = 'id';
    protected $fillable = ['work_type'];
}
