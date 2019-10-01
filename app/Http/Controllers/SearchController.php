<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        $search = request('q');
        //return Thread::search($search)->get();
        $threads = Thread::search($search)->paginate(config('forum2019.pagination.perPage'));
        
        if (request()->wantsJson()){
            return $threads;
        }
        
        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }
    
}
