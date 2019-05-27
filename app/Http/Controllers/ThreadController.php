<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'create', 'destroy']);
    }
    
    public function index(Channel $channel, ThreadFilters $filters)
    {
        
        $threads = $this->getThreads($channel, $filters);
        
        
        if (request()->wantsJson()){
            return $threads;
        }
        
        return view('threads.index', compact('threads'));
    }
    
    public function show($channel, Thread $thread)
    {
        //return $thread->load('replies');
        //return Thread::withCount('replies')->first();
        //return $thread;
        //return view('threads.show', compact('thread'));
        return view('threads.show', [
            'thread'  => $thread,
            'replies' => $thread->replies()->paginate(20),
        ]);
    }
    
    public function destroy($channel, Thread $thread)
    {
        //$thread->replies()->delete();
        $thread->delete();
        
        if (request()->wantsJson()){
            return response([], 204);
        }
        
        return redirect('/threads');
    }
    
    
    public function store(Request $request)
    {
        //dd(request()->all());
        $this->validate($request, [
            'title'      => 'required',
            'body'       => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);
        //dd($request->all());
        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body'),
        ]);
        
        return redirect($thread->path());
    }
    
    public function create()
    {
        return view('threads.create');
    }
    
    
    /**
     * @param ThreadFilters $filters
     *
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters)->latest();
        
        if ($channel->exists){
            $threads->where('channel_id', $channel->id);
        }
        
        //dd($threads->toSql());
        
        return $threads->get();
    }
    
}
