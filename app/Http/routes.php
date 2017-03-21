<?php

// REPO TEST
/*Route::get('foo', function(\App\Repositories\Eloquent\UserRepository $repo){
    dd($repo->all());
});*/

// ADMIN PANEL ACTION
/*Route::get('admin', ['middleware' => ['auth','admin'], function(){
	return 'Admin Panel';
}]);*/


Route::get('testing/{file}', function($file){

//	$storage = app()->make('App\Contracts\StorageManager');

	// simple avatar change
	if(Auth::user()){
		Auth::user()->avatar = $file;
		Auth::user()->update();

		flash()->success('Avatar changed', 'Bravo!');

		return redirect()->route('users.show', [Auth::user()->profile_link]);
	}

	return 'Need to be logged in to change avatar';


});

/*
 |--------------------------------------------------
 | User Routes
 |--------------------------------------------------
 */

Route::get('users', ['as'=>'users.index', 'uses'=>'UsersController@index']);
Route::get('users/create', ['as'=>'users.create', 'uses'=>'UsersController@create']);
Route::put('users', ['as'=>'users.store', 'uses'=>'UsersController@store']);

Route::group(['prefix' => 'users/{user}'], function(){
	Route::get('/', ['as'=>'users.show', 'uses'=>'UsersController@show']);
	Route::get('edit', ['as'=>'users.edit', 'uses'=>'UsersController@edit']);
	Route::patch('/', ['as'=>'users.update', 'uses'=>'UsersController@update']);
	Route::delete('destroy', ['as'=>'users.destroy', 'uses'=>'UsersController@destroy']);

	// Users groups:
	Route::get('groups', ['as'=>'users.groups', 'uses'=>'UsersController@groups']);

	// User media management:
	Route::get('media/images/{file_name}', 'MediaController@getImage')->name('users.getImage');
	Route::match(['post', 'put'], 'media/images', 'MediaController@storeImage')->name('users.storeImage');
	Route::delete('media/images/{file_name}/destroy', 'MediaController@destroyImage')->name('users.destroyImage');

});

/*
 |--------------------------------------------------
 | Group Routes
 |--------------------------------------------------
 */

Route::get('groups', 'GroupsController@index')->name('groups.index');
Route::get('groups/create', 'GroupsController@create')->name('groups.create');
Route::put('groups', 'GroupsController@store')->name('groups.store');

Route::group(['prefix' => 'groups/{group}'], function(){
	Route::get('/', 'GroupsController@show')->name('groups.show');
	Route::get('edit', 'GroupsController@edit')->name('groups.edit');
	Route::patch('/', 'GroupsController@update')->name('groups.update');
	Route::delete('destroy', 'GroupsController@destroy')->name('groups.destroy');

	Route::match(['get', 'post'], 'manage-members', 'GroupsController@manageMembers');
});

/*
 |--------------------------------------------------
 | User Post Routes
 |--------------------------------------------------
 */

Route::get('users/{user}/posts', 'PostsController@index')->name('posts.index');
Route::get('users/{user}/posts/create', 'PostsController@create')->name('posts.create');
Route::put('users/{user}/posts', 'PostsController@store')->name('posts.store');

Route::group(['prefix' => 'users/{user}/posts/{post}'], function(){
	Route::get('/', 'PostsController@show')->name('posts.show');
	Route::get('edit', 'PostsController@edit')->name('posts.edit');
	Route::patch('/', 'PostsController@update')->name('posts.update');
	Route::delete('destroy', 'PostsController@destroy')->name('posts.destroy');
});

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

