<?php

namespace App\Models\Benefiters_Tables_Models;

use Illuminate\Database\Eloquent\Model;

class ImportCSV_BasicInfo extends Model
{
    protected $table = 'import_csv_basic_info';

    protected $fillable = ['csv_name'];
}
