<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    protected $redirectTo = '/benefiters-list';
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'user_role_id' => 'required|max:20',
            'user_subrole_id' => 'max:20',
            'activation_status' => 'max:20',
            'is_deactivated' => 'max:20',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if ($data['user_role_id'] != 2 ) {
            return User::create([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'user_role_id' => $data['user_role_id'],
                // by default activation_status will be 0
                'activation_status' => 0,
                'is_deactivated' => 0,
            ]);
        }
        return User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'user_role_id' => $data['user_role_id'],
            'user_subrole_id' => $data['user_subrole_id'],
            // by default activation_status will be 0
            'activation_status' => 0,
            'is_deactivated' => 0,
        ]);
    }

    // get the subroles correctly in register page
    public function getRegister() {
        $subroles = \DB::table('users_subroles')->get();
        return view('auth.register')->with('subroles', $subroles);
    }

    // get redirection after registration
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());

        return redirect('/');
    }
}
