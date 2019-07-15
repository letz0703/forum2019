<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;
use App\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }
    
    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }
    
    
    /**
     * @param                                      $channelId
     * @param Thread                               $thread
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        $this->validateReply();
        
        $reply = $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => request('body'),
        ]);
        
        return $reply->load('owner');
    }
    
    public function update(Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);
        //$this->validate(request(), ['body' => 'required']);
        //$spam->detect(request('body'));
        $this->validateReply();
        $reply->update(request(['body']));
        //$reply->update(['body'=>request('body')]);
    }
    
    
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        //if ($reply->user_id != auth()->id()){
        //    return response([], 403);
        //}
        if (request()->expectsJson()){
            $reply->delete();
            return response(['status' => 'reply deleted']);
        }
        $reply->delete();
        return back();
    }
    
    public function validateReply()
    {
        $this->validate(request(), [
            'body' => 'required',
        ]);
        
        resolve(Spam::class)->detect(request('body'));
    }
    
    
}
