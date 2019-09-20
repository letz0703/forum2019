<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ChannelController extends Controller{
    //
    public function index()
    {
        return view('admin.channels.index')
            ->with('channels', Channel::with('threads')->get());
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
        
        if (request()->wantsJson()){
            return response($channel, 201);
        }
        
        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been created');
    }
    
    public function update(Request $request, Channel $channel)
    {
        $this->validate($request, [
            'name' => 'required|spamfree|unique:channels',
            'description' => 'required|spamfree'
        ]);
        
        $channel->update([
            'name' => request('name'),
            'description' => request('description')
        ]);
        
        cache()->forget('channels');
        
        if (request()->wantsJson()){
            return response($channel, 200);
        }
        
        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been updated');
        
    }
    
}
