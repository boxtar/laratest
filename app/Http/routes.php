<?php
Route::resource('users', 'UsersController');
Route::resource('groups', 'GroupsController');
Route::resource('users/{users}/posts', 'PostsController');
Route::controllers([
	'auth'		=> 'Auth\AuthController',
	'password'	=> 'Auth\PasswordController'
]);

Route::get('admin', ['middleware' => ['auth','admin'], function(){
	return 'Admin Panel';
}]);

Route::get('users/{users}/groups', 'GroupsController@getGroups');
Route::get('groups/{groups}/users', 'UsersController@getUsers');

/*
 |--------------------------------------------------
 | Contact Form Submit Controller
 |--------------------------------------------------
 */

Route::post('contact', [
	'as' => 'contact_submit',
	'uses' => 'PagesController@store'
]);

/*
 |--------------------------------------------------
 | Fallback Controller
 |--------------------------------------------------
 */

Route::controller('/', 'PagesController');

