<?php

namespace App\Policies;

use App\Post;
use App\User;

class PostPolicy
{
    public function create(User $auth_user, User $target_user)
    {
        return $auth_user->id === $target_user->id;
    }

    public function update(User $auth_user, Post $post)
    {
        return $auth_user->id === $post->owner->id;
    }
}
