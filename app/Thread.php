<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model{
    
    use RecordActivity;
    
    protected $guarded = [];
    
    protected $with = ['creator', 'channel'];
    
    protected $appends = ['isSubscribedTo'];
    
    
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
    
    /**
     * @param $reply
     *
     * @return Model
     */
    public function addReply($reply){
        $reply =  $this->replies()->create($reply);
        
        foreach($this->subscriptions as $subscription){
            $subscription->user->notify(new ThreadWasUpdated($this, $reply));
        }
        
        return $reply;
    }
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
        
    }
    
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
             ->where('user_id',$userId?:auth()->id())
             ->delete();
    }
    
    public function isSubscribedTo()
    {
        return $this->subscriptions()->where('user_id',auth()->id())->exists();
    }
    
    public function getIsSubscribedToAttribute()
    {
        return $this->isSubscribedTo();
    }
    
    
    
    public function scopeFilter($query, $filters){
        return $filters->apply($query);
    }
    
    public function getReplyCountAttribute(){
        return $this->replies()->count();
    }
    
    
}
