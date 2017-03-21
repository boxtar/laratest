<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Contracts\StorageManager;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class UsersController extends Controller
{
	/**
	 * Display all users sorted by newest first
	 *
	 * @return \Illuminate\View\View
	 */
    public function index(){
		return view(Config::get('boxtar.viewUsers'))->with('users', User::latest()->get());
	}

	/**
	 * Display a given user's profile
	 *
	 * @param $user
	 * @return \Illuminate\View\View
	 */
	public function show(User $user, StorageManager $storage){

		$images = $user->getImages($storage);

		return view(Config::get('boxtar.viewUser'), compact('user', 'images'));
	}

	/**
	 * Return a list of a given user's Groups
	 *
	 * @param User $user
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function groups(User $user)
	{
		$groups = $user->groups;

		return view(config('boxtar.viewUsersGroups'), compact('user', 'groups'));
	}
	
	/**
	 * User creation dealt with by AuthController
	 */
	public function create(){
		return redirect('/auth/register');
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(){
		return redirect('/auth/register');
	}

	/**
	 * Show form for editing User details
	 *
	 * @param $user
	 * @return \Illuminate\View\View
	 */
	public function edit($user) {
		$this->authorize('edit', $user);

		return view(Config::get('boxtar.editUser'), compact('user'));
	}

	/**
	 * Edit User account details
	 *
	 * @param UserRequest $request
	 * @param $user
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(UserRequest $request, User $user){

		$this->authorize('edit', $user);

		$user->update($request->all());

		// Also need to rename the users directory

		flash()->success('Profile Updated');

		return redirect(userProfileLink($user));

	}

	/**
	 * Soft delete User account
	 *
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
     */
	public function destroy(User $user)
	{
		$this->authorize('delete', $user);

		Auth::logout();

		$user->delete();

		flash()->info('Remember; you can always reactivate your account', 'We are sorry to see you go :(');

		return redirect('/');
	}

}
