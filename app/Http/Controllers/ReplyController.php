<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::denies('create', new Reply)) {
            return response(
                'You post too frequently. Please take a break', 422
            );
        }
        
        try {
            //$this->authorize('create', new Reply);
            $this->validate(request(), ['body' => 'required|spamfree']);
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
            $this->validate(request(), ['body' => 'required|spamfree']);
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
    
}
