<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionController extends Controller
{
    //
    public function store($channelId, Thread $thread)
    {
        if (!auth()->id()){
            return redirect('login');
        }
        
        $thread->subscribe(auth()->id());
    }
}
