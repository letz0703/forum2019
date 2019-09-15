<?php

namespace App\Http\Controllers;

use App\Thread;

class LockedThreadController extends Controller
{
    //
    public function store(Thread $thread)
    {
        //if ( ! $thread->isAdmin()){
        //    return response('You do not have permission to lock!', 403);
        // middleware 'admin' is applied}
        $thread->update(['locked' => true]);
    }
    
    public function destroy(Thread $thread)
    {
        $thread->update(['locked' => false]);
    }
    
}
