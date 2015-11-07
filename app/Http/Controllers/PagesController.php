<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
	
	public function getIndex(){
	
		return view(Config::get('boxtar.index'))->with([
			'title' => 'Welcome',
			'content' => 'Laravel 5 - Welcome'
		]);
		
	}
    
	public function getAbout(){
		
		return view(Config::get('boxtar.about'))->with([
			'title' => 'About',
			'content' => 'Laravel MVC Framework Tutorials'
		]);
		
	}

	public function getContact()
	{
		return view(Config::get('boxtar.contact'))->with([
			'title' => 'Contact Page',
			'content' => 'Contact Form'
		]);
	}

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
