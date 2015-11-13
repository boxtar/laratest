<?php
namespace App\Repositories\Eloquent;

use App\User;

class UserRepository
{
    public function all()
    {
        return ['all', 'the', 'users'];
    }
}