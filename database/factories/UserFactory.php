<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name'               => $faker->name,
        'email'              => $faker->unique()->safeEmail,
        'confirmed'          => true,
        'confirmation_token' => str_random(25),
        'email_verified_at'  => now(),
        'password'           => $password ?: bcrypt('secret'),
        'remember_token'     => Str::random(10),
    ];
});

$factory->state('App\User', 'unconfirmed', function () {
    return [
        'confirmed' => false,
    ];
});
$factory->state('App\User', 'administrator', function () {
    return [
        'isAdmin'      => true,
        //'email'     => 'rainskiss@nate.com',
        //'confirmed' => true,
    ];
});
