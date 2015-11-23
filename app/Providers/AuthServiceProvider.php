<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Model::class => 'App\Policies\ModelPolicy',
        \App\User::class  => 'App\Policies\UserPolicy',
        \App\Post::class  => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        foreach($this->getGroupPermissions() as $permission){
            $gate->define($permission->name, function(\App\User $user, \App\Group $group) use($permission){
                return $user->hasGroupRole($permission->roles, $group);
            });
        }
    }

    protected function getGroupPermissions()
    {
        return \App\GroupPermission::with('roles')->get();
    }
}
