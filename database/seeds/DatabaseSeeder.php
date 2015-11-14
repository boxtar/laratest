<?php

use App\Group;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::statement("SET foreign_key_checks = 0");

        User::truncate();

        Tag::truncate();

        Post::truncate();

        Group::truncate();

        // $this->call(UserTableSeeder::class);

        $users = factory(User::class, 10)->create();

        $tags = factory(Tag::class, 5)->create();

        $posts = factory(Post::class, 40)->create();

        $groups = factory(Group::class, 10)->create();

        Model::reguard();
    }
}
