<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required',
        ]);
        
        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => request('body'),
        ]);
        return back();
    }
    
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(request(['body']));
        //$reply->update(['body'=>request('body')]);
    }
    
    
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        //if ($reply->user_id != auth()->id()){
        //    return response([], 403);
        //}
        $reply->delete();
        return back();
    }
    
    
}
