<?php

namespace App\Http\Controllers;

use App\Contracts\Search;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{

	/**
	 * @return $this
     */
	public function getIndex(){
	
		return view(Config::get('boxtar.index'))->with([
			'title' => 'Welcome',
			'content' => 'BOXTAR UK'
		]);
		
	}

	/**
	 * @return $this
     */
	public function getAbout(){
		
		return view(Config::get('boxtar.about'))->with([
			'title' => 'About',
			'content' => 'Laravel MVC Framework Tutorials'
		]);
		
	}

	/**
	 * @return $this
     */
	public function getContact()
	{
		return view(Config::get('boxtar.contact'))->with([
			'title' => 'Contact Page',
			'content' => 'Contact Form'
		]);
	}

	/**
	 *  Temp Store method for sending mail
	 *  Ideally move this to it's own Controller
	 *
	 * @param Requests\ContactFormRequest $request
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store(Requests\ContactFormRequest $request)
	{
		Mail::send('layouts.email.contact',
					$request->except('_token'),
					function($message){
						$message->to(Config::get('boxtar.contactFormMailbox'));
					});

		flash()->success('Your Message has been Submitted. Thanks!');
		return redirect()->action('PagesController@getContact');
	}
}
