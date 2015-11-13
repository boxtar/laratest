<?php

namespace App\Http\Controllers;

use App\Group;
use App\Repositories\Contracts\Repository;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class GroupsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index', 'show']]);
		$this->middleware('group.permissions', ['only' => ['edit', 'update']]);
	}

    /**
	 *
	 */
    public function index(){
		$groups = Group::latest()->get();
		return view(Config::get('boxtar.viewGroups'), compact('groups'));
	}

	/**
	 * @param Group $group
	 * @return \Illuminate\View\View
	 */
	public function show($group){
		return view(Config::get('boxtar.viewGroup'), compact('group'));
	}
	
	/**
	 *
	 */
	public function create(){
		return view(Config::get('boxtar.createGroup'));
	}

	/**
	 * @param GroupRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(GroupRequest $request){

		$this->create_group($request);

		flash()->success('Group created!');

		return redirect('groups/'.$request->input('profile_link'));
		
	}

	/**
	 * @param $group
	 * @return \Illuminate\View\View
	 */
	public function edit($group){
		return view(Config::get('boxtar.editGroup'), compact('group'));
	}

	/**
	 * @param GroupRequest $request
	 * @param $group
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update(GroupRequest $request, $group)
	{
		$request = $this->set_owner_id($request);

		$group->update($request);

		return redirect('groups/'.$group->profile_link); //$request->input('profile_link'));
	}

	/**
	 * @param GroupRequest $request
	 * @return mixed
	 */
	private function create_group(GroupRequest $request)
	{
		$request = $this->set_owner_id($request);

		$group = Auth::user()->groups()->create($request);

//		$group->members()->attach(Auth::id(), ['permissions' => 1]);

		return $group;
	}

	/**
	 * Ensure User has not provided an owner_id input in their request
	 * This could lead to Group hijacking
	 *
	 * @param GroupRequest $request
	 * @return array $request
	 */
	private function set_owner_id(GroupRequest $request)
	{
		// Remove any user provided owner_id field
		$request = $request->except('owner_id');
		// Implant owner_id field with value of currently authenticated user
		$request['owner_id'] = Auth::id();
		return $request;
	}
}
