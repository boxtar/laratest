<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckGroupPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $group = Route::current()->parameter('groups');
        $user = Auth::user();
        if($user->id != $group->owner->id){
            flash()->error('Unauthorised Request');
            return redirect()->action('UsersController@show', [$user->profile_link]);
        }

        return $next($request);
    }
}
