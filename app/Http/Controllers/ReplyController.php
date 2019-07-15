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
     * @param        $channelId
     * @param Thread $thread
     *
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread)
    {
        try {
            $this->validateReply();
        
            $reply = $thread->addReply([
                'user_id' => auth()->id(),
                'body'    => request('body'),
            ]);
        
        } catch (\Exception $e) {
            return response('You can not leave reply this time', 422);
        }
        
        return $reply->load('owner');
    }
    
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        try {
            $this->validateReply();
            $reply->update(request(['body']));
        } catch ( \Exception $e ) {
            return response('You can not update this time', 422);
        }
        //$this->validate(request(), ['body' => 'required']);
        //$spam->detect(request('body'));
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
