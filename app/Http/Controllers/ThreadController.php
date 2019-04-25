<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store','create']);
    }
    
    public function index()
    {
        $threads = Thread::latest()->get();
        
        return view('threads.index', compact('threads'));
    }
    
    public function show(Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }
    
    public function store(Request $request)
    {
        //dd($request->all());
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' =>request('channel_id'),
            'title'   => request('title'),
            'body'    => request('body'),
        ]);
        
        return redirect($thread->path());
    }
    
    public function create()
    {
        return view('threads.create');
    }
    
    
}
