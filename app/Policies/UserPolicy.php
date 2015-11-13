<?php

namespace App\Policies;

use App\User;

class UserPolicy
{
    /*
     * Used to check that the user is trying to access their own
     * edit page
     */
    public function edit(User $authenticated_user, User $target_user)
    {
        return $authenticated_user->id === $target_user->id;
    }

    /*
     * Used to display Create Post button if Authenticated User
     * is viewing their own Posts page (pages/posts/posts.blade.php)
     */
    public function createPost(User $authenticated_user, User $target_user)
    {
        return $authenticated_user->id === $target_user->id;
    }
}
