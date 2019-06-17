<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);
        
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);
        return back();
    }
    
    public function destroy(Reply $reply){
        if ($reply->user_id != auth()->id()){
            return response([], 403);
        }
        $reply->delete();
        return back();
    }
    
    
}
