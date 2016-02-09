<?php

namespace App\Http\Controllers\MainPanel;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function getUsers(){
        return View('userPanel.users-list');
    }
}

