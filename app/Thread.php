<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    
    protected $guarded = [];
    
    //
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }
    
    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    
    
    public function addReply($reply)
    {
        $this->replies()->create($reply);
        
        return back();
    }
    
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
    
    
}
