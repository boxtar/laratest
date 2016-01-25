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

        //$this->call(UserTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(GroupTypeSeeder::class);
        $this->call(GroupRolePermissionSeeder::class);

        Model::reguard();
    }


}
