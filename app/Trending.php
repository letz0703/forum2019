<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Redis;

class Trending
{
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange('trending_threads', 0, 4));
        //$trending = collect(Redis::zrevrange('trending_threads', 0, -1))->map(function($thread){
        //    return json_decode($thread);
        //});
    }
    
    
}