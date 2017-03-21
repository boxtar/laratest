<?php

namespace App\Http\Controllers;

use App\Group;
use App\Repositories\Contracts\Repository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class GroupsController extends Controller
{

	/**
	 * GroupsController constructor.
     */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index', 'show']]);
	}

	/**
	 * Returns a view that simply lists Groups
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index(){
		$groups = Group::latest()->get();
		return view(Config::get('boxtar.viewGroups'), compact('groups'));
	}

	/**
	 * Returns a view that displays group info and media
	 *
	 * @param Group $group
	 * @return \Illuminate\View\View
	 */
	public function show(Group $group){
		return view(Config::get('boxtar.viewGroup'), compact('group'));
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function create(){
		return view(Config::get('boxtar.createGroup'));
	}

	/**
	 * Creates Group and assigns Authenticated User the Administrator Role
	 *
	 * @param GroupRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(GroupRequest $request){

		$group = $request->user()->createGroup($request);

		flash()->success($group->name.' successfully created','Its Time To Be Discovered!');

		return redirect('groups/'.$request->input('profile_link'));
		
	}

	/**
	 * Returns a view that allows the Group to be edited
	 * only if the Authenticated User is authorised
	 *
	 * @param $group
	 * @return \Illuminate\View\View
	 */
	public function edit($group){

		$this->authorize('edit_details', $group);

		return view(Config::get('boxtar.editGroup'), compact('group'));
	}

	/**
	 * Updates Group details if the Authenticated User is authorised
	 *
	 * @param GroupRequest $request
	 * @param Group $group
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(GroupRequest $request, Group $group)
	{
		$this->authorize('edit_details', $group);

		$group->update($request->all());

		flash()->success('Group details updated', 'Awesome!');

		return redirect(groupProfileLink($group)); //$request->input('profile_link'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Group $group
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Group $group)
	{
		$this->authorize('delete_group', $group);

		$group->delete();

		flash()->success('You can always reactivate if you wish', $group->name.' has left the building :(');

		return redirect( userProfileLink( Auth::user() ) );
	}

	/**
	 * For Testing Management of Group Members
	 *
	 * @param Group $group
	 * @return string
     */
	public function manageMembers(Request $request, Group $group)
	{
		$this->authorize('manage_members', $group);

		if(strtolower($request->method()) == 'post'){

			// Find User
			if(! $user = User::whereProfileLink($request->q)->first() ){
				flash()->error('User not found', 'Could Not Invite User');
				return view(config('boxtar.manageMembers'), compact('group'))->with('members', $group->members->except(Auth::id()));
			}

			// Make sure user isn't already a member of group
			if( $user->groups->has($group->id) ){
				flash()->error($user->name . ' is already a member', 'Could Not Invite User');
				return view(config('boxtar.manageMembers'), compact('group'))->with('members', $group->members->except(Auth::id()));
			}

			// Send invitation (temp: add user)
			$user->groups()->attach($group->id, ['role_id' => 3]);

			flash()->success($user->name . ' invited to ' . $group->name, 'Nice!');

		}

		$members = $group->members->except(Auth::id());

		return view(config('boxtar.manageMembers'), compact('group', 'members'));

	}
}
