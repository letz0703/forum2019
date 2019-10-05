<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        $threads = Thread::search(request('query'))
                         ->paginate(config('forum2019.pagination.perPage'));

        if (request()->expectsJson()) {
            return $threads;
        }

        return view('threads.search', [
            'threads'  => $threads,
            'trending' => $trending->get(),
        ]);
    }
}
