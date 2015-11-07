<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class UsersController extends Controller
{
	/**
	 * Display all users sorted by newest first
	 * @return Illuminate\View;
	 */
    public function index(){
		return view(Config::get('boxtar.viewUsers'))->with('users', User::latest()->get());
	}

	/**
	 * @param $user
	 * @return \Illuminate\View\View
	 */
	public function show($user){
		return view(Config::get('boxtar.viewUser'), compact('user'));
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
	 * @param UserRequest $request
	 * @param $user
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(UserRequest $request, $user){
		$user->update($request->all());

		flash()->success('Profile Updated');

		return redirect('users/'.$request->input('profile_link'));
	}
}
