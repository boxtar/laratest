<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $name = $faker->name;
    $prof_link = preg_replace('/\s/', '-', $name);
    return [
        'name' => $name,
        'email' => $faker->email,
        'profile_link' => $prof_link,
        'password' => 'admin',
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    $user = \App\User::all()->random();
    return [
        'owner_id' => $user->id,
        'message' => $faker->paragraph(),
    ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker) {
    $user = \App\User::all()->random();
    return [
        'name' => $faker->domainName,
        'profile_link' => str_random(16),
        'group_type_id' => $faker->numberBetween(1,3)
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(['PHP', 'C', 'C++', 'JS', 'Other'])
    ];
});