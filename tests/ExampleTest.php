<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_it_loads_the_home_page()
    {
        $this->visit('/')
            ->see('Laravel 5');
    }

    public function test_it_ensures_only_authorized_users_can_edit_post()
    {
        $johnpaul = User::whereProfileLink('johnpaul')->first();
        $frankie = User::whereProfileLink('frankie')->first();

        $johnpaul_post = $johnpaul->posts()->first();

        $this->actingAs($johnpaul)
             ->visit('users/'.$johnpaul->profile_link.'/posts')
             ->click($johnpaul_post->message)
             ->see('Edit Post');
    }


}