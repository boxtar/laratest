<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
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
	protected $redirectTo;

    // name of email/username input field in login form
    protected $username = 'login_name';

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);

        $this->redirectTo = '/' . config('boxtar.usersPrefix');
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
			'profile_link'	=> 'required|unique:users|min:5|max:30|alpha_dash',
			'password'		=> 'required|min:5|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * And create the Users storage space and provide default avatar
     *
     * JPM 24th January 2016
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'profile_link' => $data['profile_link'],
        ]);

        $user = User::find($user->id);

        $this->createUsersStorageSpace($user);

        $this->redirectTo = '/users/'.$user->profile_link;

        return $user;
    }

    /**
     * Creates directories and default avatar for newly registered User
     *
     * JPM 24th January 2016
     *
     * @param User $user
     */
    protected function createUsersStorageSpace(User $user)
    {
        // Get Storage Manager Instance
        $storage = app()->make('App\Contracts\StorageManager');

        // Creates the new users directories on disk and copies over default files
        $storage->cd( config('boxtar.userStoragePath'))
            ->createDirectory($user->profile_link)->cd($user->profile_link)
            ->createDirectories([
                    config('boxtar.userImagePath'),
                    config('boxtar.userMusicPath'),
                    config('boxtar.userVideoPath'),
                    config('boxtar.userDataPath')
                ])
            ->cd( config('boxtar.userImagePath') )
            ->copyFile( config('boxtar.defaultAvatar'), $user->avatar );

    }

    /**
     * Override the Laravel provided postLogin functionality to add
     * the ability to let a user login using email address or profile_link
     *
     * JPM 24th January 2016
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Overwrite where the user is redirected to after successful authentication
     *
     * JPM 24th January 2016
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request, User $user)
    {
        return redirect()->intended($this->redirectTo . '/' . $user->profile_link);
    }
}
