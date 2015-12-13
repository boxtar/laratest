<?php

// REPO TEST
/*Route::get('foo', function(\App\Repositories\Eloquent\UserRepository $repo){
    dd($repo->all());
});*/

Route::resource('users', 'UsersController');
//Route::get('users/{users}/groups', 'GroupsController@getGroups');

Route::resource('groups', 'GroupsController');
//Route::get('groups/{groups}/users', 'GroupsController@getUsers');

Route::get('groups/{groups}/manage-members', 'GroupsController@manageMembers');

Route::resource('users/{users}/posts', 'PostsController');

Route::controllers([
	'auth'		=> 'Auth\AuthController',
	'password'	=> 'Auth\PasswordController'
]);

Route::get('admin', ['middleware' => ['auth','admin'], function(){
	return 'Admin Panel';
}]);

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

