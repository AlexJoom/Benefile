<?php

namespace App\Http\Controllers\MainPanel;

use DB;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function UsersList(){
        $users = User::with('role', 'subrole')->get();
        return view('userPanel.users-list', compact('users'));
    }

    public function ToBeActivated(){
        $users = User::with('role', 'subrole')->get();
        return view('userPanel.users-list', compact('users'));
    }
}


