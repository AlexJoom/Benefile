<?php

namespace App\Http\Controllers\MainPanel;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller{

    private $userService = null;

    public function __construct(){
        $this->userService = new UserService();
        // only for logged in users
        $this->middleware('admin');
    }

    public function UsersList(){
       $users =  $this->userService->getAllUsers();
        return view('users.users-list', compact('users'));
    }

    public function UserStatusUpdate(Request $request){
        $this->userService->AdminUpdateUserStatus($request['user_id']);
        return redirect('main-panel/users-list');
    }
}


