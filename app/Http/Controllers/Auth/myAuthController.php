<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Models\User;


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
    // property that defines our redirectTo path
    private $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->auth = $auth;
//        $this->registrar = $registrar;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * show login view
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }


    /**
     * check login credentials
     *
     * @param Request $request
     * @return string
     */
    public function postLogin(Request $request)
    {
        // make a rules table
        $rules = [
            'email' => 'required|email',
            'password' => 'required|max:60|min:6' // !!!possibly min and max addition, maybe alphaNum?!!!
        ];
        // is the input valid?
        $validator = Validator::make($request->all(), $rules);
        // check if the validation fails or not
        if ($validator->fails()) {
            return redirect('/auth/login')->withErrors($validator)->withInput($request->except('password'));
        } else {
            // attempt to authorize the user
            if ($this->auth->attempt(array('email' => $request->email, 'password' => $request->password))) {
                /*
                 * authentication success
                 */
            }
            return redirect('/auth/login')->withErrors(\Lang::get('login.wrong_credentials'));
        }
    }

    /**
     * show the register view
     *
     * @return \Illuminate\View\View
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * check registration credentials and redirect to login page
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postRegister(Request $request)	{
        $validator =$this->ValidateRegistrationRequest($this->CreateArrayForValidation($request));
        if ($validator->fails()) {
            return redirect('/auth/register')->withErrors($validator)->withInput($request->except('password'));
        } else {
            $this->SaveUser($request);
            $this->SendEmailToUser($request);
            $this->SendEmailToAdmin($request->email, $request->coupon);
            return redirect('/auth/login')->withSuccess(\Lang::get('register.register_success'));
        }
    }

    //SRP singe responsibility principle. Every method does exactly one thing
    private function ValidateRegistrationRequest($request)
    {
        return Validator::make(
            $request,
            array(
                'name' => 'required|max:255',
//                'lastname' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
//                'user_role_id' => 'required',
//                'user_subrole_id' => 'required',
            )
        );
    }

    // create new array with request values and accesscode
    private function CreateArrayForValidation($request){
        return array(
            'name' => $request->name,
//            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password,
//            'user_role_id' => $request->user_role_id,
//            'user_subrole_id' => $request->user_subrole_id,
        );
    }

    private function SaveUser($request)
    {
        User::create([
            'name' => $request->name,
//            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
//            'user_role_id' => $request->user_role_id,
//            'user_subrole_id' => $request->user_subrole_id,
        ]);
    }

    // returns the new user's id
    private function GetNewRegisteredUser($request) {
        return User::where('email', '=', $request->email)->first();
    }

    private function SendEmailToUser($request){
        \Mail::send('emails.register', array(), function ($message) use ($request) {
            $message->to($request->email, $request->email)->subject(\Lang::get('register.mail_subject'));
        });
    }

    private function SendEmailToAdmin($user_email, $coupon){
        \Mail::send('emails.register_admin', array('user_email' =>$user_email, 'coupon' => $coupon), function ($message) use ($user_email, $coupon) {
            $message->to('info@artvioma.gr', 'Admin')->subject(\Lang::get('register.mail_subject_admin'));
        });
    }

    /**
     * logout...
     */
    public function getLogout()
    {
        $this->auth->logout();
        return redirect('/auth/login');
    }


//    --------------------------------------------------------------------------------------------------------------

//    /**
//     * Get a validator for an incoming registration request.
//     *
//     * @param  array  $data
//     * @return \Illuminate\Contracts\Validation\Validator
//     */
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'name' => 'required|max:255',
//            'lastname' => 'required|max:255',
//            'email' => 'required|email|max:255|unique:users',
//            'password' => 'required|confirmed|min:6',
//            'user_role_id' => 'required',
//            'user_subrole_id' => 'required',
//        ]);
//    }
//
//    /**
//     * Create a new user instance after a valid registration.
//     *
//     * @param  array  $data
//     * @return User
//     */
//    protected function create(array $data)
//    {
//        return User::create([
//            'name' => $data['name'],
//            'lastname' => $data['lastname'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//            'user_role_id' => $data['user_role_id'],
//            'user_subrole_id' => $data['user_subrole_id'],
//        ]);
//    }
}
