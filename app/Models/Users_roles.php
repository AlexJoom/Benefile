<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_roles extends Model
{
    protected $table = 'users_roles';
    protected $primaryKey = 'id';
    protected $fillable = ['role'];
}
