<?php

namespace App\Http\Controllers;

use App\Reply;

class BestReplyController extends Controller
{
    //
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);
        //abort_if($reply->thread->user_id !== auth()->id(), 401);
        //if ( auth()->id() == $reply->thread->user_id){
        $reply->thread->update(['best_reply_id' => $reply->id]);
        //}
    }
}
