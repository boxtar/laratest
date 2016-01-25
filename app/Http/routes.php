<?php

// REPO TEST
/*Route::get('foo', function(\App\Repositories\Eloquent\UserRepository $repo){
    dd($repo->all());
});*/

// ADMIN PANEL ACTION
/*Route::get('admin', ['middleware' => ['auth','admin'], function(){
	return 'Admin Panel';
}]);*/



/*
 |--------------------------------------------------
 | User Routes
 |--------------------------------------------------
 */

Route::resource('users', 'UsersController');

Route::group(['prefix' => 'users/{users}'], function(){
	Route::get('destroy', 'UsersController@destroy');
	Route::get('groups', 'UsersController@groups');
	Route::post('upload_image', 'UsersController@addImage');
	Route::get('get-image/{image}', 'UsersController@getImage');
});

/*
 |--------------------------------------------------
 | Group Routes
 |--------------------------------------------------
 */

Route::resource('groups', 'GroupsController');

Route::group(['prefix' => 'groups/{groups}'], function(){
	Route::get('destroy', 'GroupsController@destroy');
	Route::match(['get', 'post'], 'manage-members', 'GroupsController@manageMembers');
});

/*
 |--------------------------------------------------
 | Post Routes
 |--------------------------------------------------
 */

Route::resource('users/{users}/posts', 'PostsController');

/*
 |--------------------------------------------------
 | Authentication and Password Reset Routes
 |--------------------------------------------------
 */

Route::controllers([
	'auth'		=> 'Auth\AuthController',
	'password'	=> 'Auth\PasswordController'
]);

/*
 |--------------------------------------------------
 | Searching Controllers
 |--------------------------------------------------
 */

Route::get('search', 'SearchController@search');
Route::get('hint-search', 'SearchController@hintSearch');

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

