<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    
    protected $guarded = [];
    
    protected $with = ['creator', 'channel'];
    
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder){
            $builder->withCount('replies');
        });
        
        static::deleting(function ($thread){
            $thread->replies()->delete();
        });
        
        static::created(function ($thread){
            Activity::create([
                'user_id'      => auth()->id(),
                'type'         => 'created_thread',
                'subject_id'   => $thread->id,
                'subject_type' => 'App\Thread',
            ]);
        });
        
        //static::addGlobalScope('creator', function ($builder){
        //    $builder->with('creator');
        //});
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
        return $this->hasMany(Reply::class);
        //->withCount('favorites')
        //->with('owner');
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
