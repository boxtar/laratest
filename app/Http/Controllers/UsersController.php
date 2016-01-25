<?php

namespace App\Http\Controllers;

use App\Contracts\StorageManager;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Image;

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
	public function show(User $user){
		return view(Config::get('boxtar.viewUser'), compact('user'));
	}

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
	 * @param UserRequest $request
	 * @param $user
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(UserRequest $request, User $user){

		$this->authorize('edit', $user);

		$user->update($request->all());

		flash()->success('Profile Updated');

		return redirect('users/'.$request->input('profile_link'));

	}

	public function destroy(User $user)
	{
		$this->authorize('delete', $user);

		Auth::logout();

		$user->delete();

		flash()->info('Remember; you can always reactivate your account', 'We are sorry to see you go :(');

		return redirect('/');
	}

	public function addImage(User $user, Request $request)
	{
		// Authorize the ability to add an image
		$this->authorize('edit', $user);

		// get the UploadedFile instance
		$file = $request->file('image');

		// generate a unique file name by using the time function
		$name = time() . $file->getClientOriginalName();

		Image::make($file)->save(storage_path('app/'.$name));

		// Move from tmp storage to permanent storage
//		$file->move('img/' . $user->profile_link, $name);

		return 'image uploaded';
	}

	public function getImage(User $user, $imageName, StorageManager $storage)
	{
		// Use Intervention to make the image from file
		$img = Image::make( $storage->getFile(
				config('boxtar.userStoragePath') . '/' .
				$user->profile_link . '/' .
				config('boxtar.userImagePath') . '/' .
				$imageName
			)
		);

		// HARD CODED TO .JPG - TEMP
		// Intervention provides all the required data for returning an image response
		return $img->response('jpg');

	}
}
