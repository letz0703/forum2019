<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Trending;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use Illuminate\Validation\Rule;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'create', 'destroy']);
    }

    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads'  => $threads,
            'trending' => $trending->get(),
        ]);
    }

    public function show($channel, Thread $thread, Trending $trending)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        $thread->visits()->record();

        $trending->push($thread);

        //return $thread->load('replies');
        //return Thread::withCount('replies')->first();
        //return $thread;
        //return view('threads.show', compact('thread'));
        return view('threads.show', compact('thread'));
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        //if ($thread->user_id != auth()->id()){
        //    abort (403,' Your Do not Have Permission');
        //    //if (request()->wantsJson()){
        //    //    return response(['status' => 'Permission Denied'], 403);
        //    //}
        //    //
        //    //return redirect('/login');
        //}

        //$thread->replies()->delete();
        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Recaptcha $recaptcha)
    {
        request()->validate([
            'title'                => 'required|spamfree',
            'body'                 => 'required|spamfree',
            'channel_id'           => ['required',
                Rule::exists('channels', 'id')
                    ->where(function ($query) {
                        $query->where('archived', false);
                    })],
            'g-recaptcha-response' => ['required', $recaptcha],
        ]);

        //if ( Thread::whereTitle(request('title'))->exists()){
        //
        //    preg_replace_callback(/\d+$/, function($slug){ }, $max);
        //    $this->incrementSlug();
        //}
        $slug = str_slug(request('title'));

        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body'),
        ]);

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published');
    }

    public function create()
    {
        return view('threads.create', [
            'channels' => Channel::all(),
        ]);
    }

    public function update($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        $thread->update(request()->validate([
            'title' => 'required|spamfree',
            'body'  => 'required|spamfree',
        ]));
    }

    /**
     * @param ThreadFilters $filters
     *
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::orderBy('pinned', 'DESC')
                         ->latest()
                         ->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(config('forum2019.pagination.perPage'));

        //dd($threads->toSql());

        //return $threads->get();
    }
}
