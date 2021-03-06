<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Http\Requests\CreatePostRequest;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(config('forum2019.pagination.perPage'));
    }

    /**
     * @param                   $channelId
     * @param Thread            $thread
     * @param CreatePostRequest $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($channelId, Thread $thread, CreatePostRequest $request)
    {
        if ($thread->locked) {
            return response('This is locked', 422);
        }

        return $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => request('body'),
        ])->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        request()->validate(['body' => 'required|spamfree']);
        $reply->update(request(['body']));
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
        if (request()->expectsJson()) {
            $reply->delete();

            return response(['status' => 'reply deleted']);
        }
        $reply->delete();

        return back();
    }
}
