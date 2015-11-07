<?php

namespace App\Policies;

use App\User;

class UserPolicy
{
    public function edit(User $authenticated_user, User $target_user)
    {
        return $authenticated_user->id === $target_user->id;
    }
}
