<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Thread::class, function (Faker $faker){
    $title = $faker->sentence;
    return [
        'user_id'    => function (){
            return factory('App\User')->create()->id;
        },
        'channel_id' => function (){
            return factory('App\Channel')->create()->id;
        },
        'title'      => $title,
        'slug'       => str_slug($title),
        'body'       => $faker->paragraph(),
        'locked'     => false
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

$factory->define(\App\Channel::class, function (Faker $faker){
    $name = $faker->word;
    
    return [
        'name' => $name,
        'slug' => $name,
    ];
});
