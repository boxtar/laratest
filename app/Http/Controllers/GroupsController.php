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

		$group = $request->user()->createGroup($request);

		flash()->success('New Group '.$group->name.' created!');

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
		$group->update($request);

		return redirect('groups/'.$group->profile_link); //$request->input('profile_link'));
	}

	public function addUser()
	{
		return "working";
	}

}
