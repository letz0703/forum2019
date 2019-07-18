<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\User;

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
     * @param                   $channelId
     * @param Thread            $thread
     *
     * @param CreatePostRequest $request
     *
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, CreatePostRequest $request)
    {
        $reply = $thread->addReply(['user_id' => auth()->id(), 'body' => request('body')]);
        
        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);
        //dd($matches);
        
        $names = $matches[1];
        
        foreach ($names as $name){
            $user = User::whereName($name)->first();
            //dd($user);
            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
        }
        
        return $reply->load('owner');
    }
    
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        try {
            $this->validate(request(), ['body' => 'required|spamfree']);
            $reply->update(request(['body']));
        } catch (\Exception $e) {
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
