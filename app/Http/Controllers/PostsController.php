<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\User;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Config;

/**
 * Class PostsController
 * @package App\Http\Controllers
 */
class PostsController extends Controller
{

    /**
     * Create a new posts controller instance
     */
    public function __construct(){
        $this->middleware('auth', ['except'=>'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user)
    {
        // route model binding makes this possible (see App\Providers\RouteServiceProvider)
		$posts	= $user->posts;

		return view(Config::get('boxtar.viewPosts'), compact("user", "posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function create($user)
    {
         // Clean up the URL before letting Authenticated User Post
        if(Auth::id() != $user->id)
            return redirect('users/'.Auth::user()->profile_link.'/posts/create');

        return view(Config::get('boxtar.createPost'), compact('user'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @param PostRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PostRequest $request, User $user)
    {
        // create the post
		$this->create_post($request);

        // laracasts flash package
        flash()->success('Your post has been created', 'Post Created');

		// Redirect to PostsController@index:
		return redirect('users/'.$user->profile_link.'/posts');
    }

    /**
     * Display the specified resource
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show()
    {
        return redirect('users/'.Auth::user()->profile_link.'/posts');
    }

    /**
     * @param User $user
     * @param Post $post
     * @return \Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(User $user, Post $post)
    {
        // Ensure authenticated user is authorized to perform this action
        $this->authorize('updatePost', $post);

        return view(Config::get('boxtar.editPost'), compact("user", "post"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param User $user
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PostRequest $request, User $user, Post $post)
    {
        $post->update($request->all());
        // Using Input instead of Request due to an error when no tags selected
        $this->sync_tags($post, \Input::get('tag_list'));

        return redirect('users/'.$user->profile_link.'/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * Save a new Post to DB
     *
     * @param PostRequest $request
     */
    private function create_post(PostRequest $request){
        // Save new Post to DB with owner as currently logged in user:
        $post = Auth::user()->posts()->create($request->all());
        // Save tags associated with the new post to the pivot table (belongsToMany relation)
        // Using Input instead of Request due to an error when no tags selected
        $this->sync_tags($post, \Input::get('tag_list'));
    }

    /**
     * Keep tags associated with post in sync
     *
     * @param Post $post
     * @param array $tags
     */
    private function sync_tags(Post $post, $tags){
        $post->tags()->sync((array) $tags);
    }

    /**
     * check if the requesting user is also the owner of the post
     *
     * @param User $user
     * @return bool
     */
    private function is_user_owner(User $user){
        if(! $auth_user = Auth::user())
            return false;

        return $user->id == $auth_user->id;
    }
}
