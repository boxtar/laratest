<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    use AuthenticatesAndRegistersUsers{
        postLogin as traitPostLogin;
    }
    use ThrottlesLogins;

	// redirect path post registration
	protected $redirectTo = '/users';

    // name of email/username input field in login form
    protected $username = 'login_name';

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' 			=> 'required|min:5|max:30',
			'email' 		=> 'required|email|unique:users',
			'password'		=> 'required|min:5',
			'profile_link'	=> 'required|unique:users|min:5|max:30'
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
			'profile_link' => $data['profile_link'],
        ]);
    }

    public function postLogin(Request $request)
    {
        // Users input (profile link or email address)
        $user_input = $request->input($this->username);
        // Did user attempted login with email address or profile link
        $username = ( filter_var($user_input, FILTER_VALIDATE_EMAIL) ) ? 'email' : 'profile_link';
        // Merge the Database key into the request
        $request->merge([$username => $user_input]);
        // Change the class' username field to the Database Key
        $this->username = $username;
        // Pass request off to Trait Function
        return $this->traitPostLogin($request);
    }
}
