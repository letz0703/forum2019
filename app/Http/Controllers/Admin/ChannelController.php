<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class ChannelController extends Controller
{
    //
    public function index()
    {
        $channels = Channel::withoutGlobalScopes()->with('threads')->get();
        
        return view('admin.channels.index', compact('channels'));
    }
    
    public function create()
    {
        return view('admin.channels.create');
    }
    
    public function store()
    {
        $data = request()->validate([
            'name'        => 'required|unique:channels',
            'description' => 'required',
        ]);
        
        $channel = Channel::create($data + ['slug' => str_slug($data['name'])]);
        
        Cache::forget('channels');
        
        if (request()->wantsJson()) {
            return response($channel, 201);
        }
        
        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been created');
    }
    
    public function edit(Channel $channel)
    {
        return view('admin.channels.edit', compact('channel'));
    }
    
    public function update(Request $request, Channel $channel)
    {
        $this->validate($request, [
            //'name'        => 'required|spamfree|unique:channels',
            'name'        => [
                'required', Rule::unique('channels')
                                ->ignore($channel->id),
            ],
            'description' => 'required|spamfree',
            'archived'    => 'required|boolean',
        ]);
        
        $channel->update([
            'name'        => request('name'),
            'slug'        => $channel->make_slug(request('name')),
            'description' => request('description'),
            'archived'    => request('archived'),
        ]);
        
        cache()->forget('channels');
        
        if (request()->wantsJson()) {
            return response($channel, 200);
        }
        
        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been updated');
    }
}
