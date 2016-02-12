<?php

namespace App\Http\Controllers\MainPanel;

use DB;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function UsersList(){
        $users = User::with('role', 'subrole')->get();
        return view('userPanel.users-list', compact('users'));
    }


    public function UserStatusUpdate(Request $request){
        $users = User::with('role', 'subrole')->get();

        foreach($users as $user){
            if($user['id'] == $request['user_id']){

                // User waiting for activation is activated
                if($user['activation_status'] == '0' && $user['is_deactivated'] == '0'){
                    $user['activation_status'] = 1;
                    $user->save();
                // Active user is deactivated
                }elseif($user['activation_status'] == '1' && $user['is_deactivated'] == '0'){
                    $user['activation_status'] = 0;
                    $user['is_deactivated'] = 1;
                    $user->save();
                // Reactivate previously deactivated used
                }else{
                    $user['activation_status'] = 1;
                    $user['is_deactivated'] = 0;
                    $user->save();
                }
            }
        }
        return redirect('main-panel/users-list');
    }

//    public function ToBeActivated(Request $request){
//        $users = User::with('role', 'subrole')->get();
//
//        foreach($users as $user){
//            if($user['id'] == $request['user_id']){
//                $user['activation_status'] = 1;
//                if($user['is_deactivated'] == 1){
//                    $user['is_deactivated'] = 0;
//                }
//                $user->save();
//            }
//        }
//        return view('userPanel.users-list', compact('users'));
//    }

//    public function DeActivate(Request $request){
//        $users = User::with('role', 'subrole')->get();
//
//        foreach($users as $user){
//            if($user['id'] == $request['user_id']){
//                $user['activation_status']= 0;
//                $user->save();
//            }
//        }
//        return view('userPanel.users-list', compact('users'));
//    }
}


