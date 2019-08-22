<?php

namespace App;

use App\Notifications\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;
    
    protected $guarded = [];
    protected $with = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];
    
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($thread){
            $thread->replies->each->delete();
            //$thread->replies->each(function ($reply){
            //    $reply->delete();
            //});
        });
        
        static::created(function($thread){
            $thread->update(['slug' => $thread->title]);
        });
        
        //static::deleting(function ($thread){
        //    $thread->replies()->delete();
        //});
        
        //static::addGlobalScope('creator', function ($builder){
        //    $builder->with('creator');
        //});
    }
    
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
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
    
    /**
     * @param $reply
     *
     * @return Model
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);
        
        event(new ThreadReceivedNewReply($reply));
        
        //event(new ThreadHasNewReply($this, $reply));
        //$this->notifySubscribers($reply);
        
        return $reply;
        
        //$this->subscriptions
        //    ->filter(function ($sub) use ($reply){
        //        return $sub->user_id != $reply->user_id;
        //    })
        //    ->each->notify($reply);
        
        //foreach ($this->subscriptions as $subscription){
        //    if ($subscription->user_id != $reply->user_id){
        //$subscription->user->notify(new ThreadWasUpdated($this, $reply));
        //}
        //} 
    }
    
    //public function notifySubscribers($reply)
    //{
    //$this->subscriptions
    //    ->where('user_id', '!=', $reply->user_id)
    //    ->each
    //    ->notify($reply);
    //}
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    
    /**
     * @param null $userId
     *
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ? : auth()->id(),
        ]);
        
        return $this;
        
    }
    
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
             ->where('user_id', $userId ? : auth()->id())
             ->delete();
    }
    
    public function isSubscribedTo()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }
    
    public function getIsSubscribedToAttribute()
    {
        return $this->isSubscribedTo();
    }
    
    public function visits()
    {
        return new Visits($this);
    }
    
    
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
    
    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }
    
    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);
        return $this->updated_at > cache($key);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);
        $origin = $slug;
        $count = 2;
        while (static::whereSlug($slug)->exists()){
            $slug = "{$origin}-" . $count++;
        }
        $this->attributes['slug'] = $slug;
        
    }
}
