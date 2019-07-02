<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model{
    
    use RecordActivity;
    
    protected $guarded = [];
    
    protected $with = ['creator', 'channel'];
    
    protected static function boot(){
        parent::boot();
        
        static::deleting(function ($thread){
            $thread->replies->each->delete();
            //$thread->replies->each(function ($reply){
            //    $reply->delete();
            //});
        });
        
        //static::deleting(function ($thread){
        //    $thread->replies()->delete();
        //});
        
        //static::addGlobalScope('creator', function ($builder){
        //    $builder->with('creator');
        //});
    }
    
    
    //
    public function path(){
        return "/threads/{$this->channel->slug}/{$this->id}";
    }
    
    public function creator(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function replies(){
        return $this->hasMany(Reply::class);
        //->withCount('favorites')
        //->with('owner');
    }
    
    public function channel(){
        return $this->belongsTo(Channel::class);
    }
    
    public function addReply($reply){
        return $this->replies()->create($reply);
    }
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ? : auth()->id()
        ]);
    }
    
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
             ->where('user_id',$userId?:auth()->id())
             ->delete();
    }
    
    public function scopeFilter($query, $filters){
        return $filters->apply($query);
    }
    
    public function getReplyCountAttribute(){
        return $this->replies()->count();
    }
    
    
}
