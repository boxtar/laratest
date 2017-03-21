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

    /**
     * User to check user is trying to delete their own account
     *
     * @param User $authenticated_user
     * @param User $target_user
     * @return bool
     */
    public function delete(User $authenticated_user, User $target_user)
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


    /**
     * Used to determine if authenticated user can manage media for a given user
     * A user can only manage their own media
     *
     * @param User $authenticated_user
     * @param User $target_user
     * @return bool
     */
    public function manage_media(User $authenticated_user, User $target_user)
    {
        return $authenticated_user->id === $target_user->id;
    }
}
