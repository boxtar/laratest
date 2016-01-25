<?php

namespace App\Providers;

use App\Contracts\Search;
use App\Contracts\StorageManager;
use App\Services\AlgoliaSearch;
use App\Services\EloquentSearch;
use App\Services\LaravelStorageManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Search::class, function(){
            return new EloquentSearch();
        });

        $this->app->singleton(StorageManager::class, function(){
           return new LaravelStorageManager(
               $this->app->make('filesystem')
           );
        });
    }
}
