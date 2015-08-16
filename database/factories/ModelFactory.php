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

// Generate a normal user
$factory->define(App\User::class, function ($faker) {

    $roleHelper = new \App\Helpers\Roles();

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
        'role_id' => $roleHelper->getUserRoleId()
    ];
});

// Generate an administrator user
$factory->defineAs(App\User::class, 'admin', function($faker) use ($factory) {

    $roleHelper = new \App\Helpers\Roles();
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['role_id' => $roleHelper->getAdminRoleId()]);

});

// Generate an moderator user
$factory->defineAs(App\User::class, 'moderator', function($faker) use ($factory) {

    $roleHelper = new \App\Helpers\Roles();
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['role_id' => $roleHelper->getModeratorRoleId()]);

});
