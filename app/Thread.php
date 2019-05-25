<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder){
           $builder->withCount('replies');
        });
    }
    
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
        return $this->hasMany(Reply::class)
                    ->withCount('favorites')
                    ->with('owner');
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
    
    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }
    
    
}
