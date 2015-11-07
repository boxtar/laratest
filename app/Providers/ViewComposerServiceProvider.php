<?php

namespace App\Providers;

use App\Tag;
use Illuminate\Support\ServiceProvider;
use Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeNavigation();
        $this->composeTagList();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Compose the navbar view
     * Provides the authenticated user to the navbar for some outputting and link setup
     */
    public function composeNavigation(){
        view()->composer('layouts.partials.navbar', function($view){
            $view->with('user', Auth::user());
        });
    }

    /**
     * Compose any view that requires a Post form (e.g. create or edit a post)
     * This ensures that the tag list is provided for the select element
     */
    public function composeTagList(){
        view()->composer('pages.posts.partials.form', function($view){
            $view->with('tags', Tag::lists('name', 'id'));
        });
    }
}
