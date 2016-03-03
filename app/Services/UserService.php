<?php
/**
 * Created by PhpStorm.
 * User: cdimitzas
 * Date: 12/2/2016
 * Time: 3:28 μμ
 */

namespace app\Services;
use App\Models\User;
use App\Http\Requests;

class UserService {
    public function AdminUpdateUserStatus($user_id){
        $users = User::with('role', 'subrole')->get();
        foreach($users as $user){
            if($user['id'] == $user_id){

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
    }

    public function getAllUsers(){
        $users = User::with('role', 'subrole')->where('user_role_id', '<>', 1)->get();
        return $users;
    }
} 
