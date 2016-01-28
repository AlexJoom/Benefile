<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_subroles extends Model
{
    protected $table = 'users_subroles';
    protected $primaryKey = 'id';
    protected $fillable = ['subrole'];
}
