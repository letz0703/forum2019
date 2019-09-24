<?php

namespace App\Http\Controllers\Api;

use App\Channel;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function index()
    {
        return cache()->rememberForever('channels', function (){
            return Channel::all();
        });
    }
}

