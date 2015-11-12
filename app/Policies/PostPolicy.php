<?php

namespace App\Policies;

use App\Post;
use App\User;

class PostPolicy
{
    public function updatePost(User $auth_user, Post $post)
    {
        return $auth_user->id === $post->owner->id;
    }
}
