<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Thread::class, function (Faker $faker){
    return [
        'user_id' => function (){
            return factory('App\User')->create()->id;
        },
        'title'   => $faker->sentence(),
        'body'    => $faker->paragraph(),
    ];
});

$factory->define(\App\Reply::class, function (Faker $faker){
    return [
        'user_id'   => function (){
            return factory('App\User')->create()->id;
        },
        'thread_id' => function (){
            return factory('App\Thread')->create()->id;
        },
        'body'      => $faker->paragraph(),
    ];
});
