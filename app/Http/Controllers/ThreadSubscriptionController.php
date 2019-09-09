<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptionController extends Controller
{
    //
    public function store($channelId, Thread $thread)
    {
        if (! auth()->id()) {
            return redirect('login');
        }

        $thread->subscribe(auth()->id());
    }

    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
