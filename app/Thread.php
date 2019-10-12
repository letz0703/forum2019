<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadReceivedNewReply;

class Thread extends Model
{
    use RecordActivity, Searchable;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];
    protected $casts = [
        'locked' => 'boolean',
        'pinned' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
            Reputation::swipe(auth()->user(), Reputation::THREAD_WAS_PUBLISHED);
            //$thread->replies->each(function ($reply){
            //    $reply->delete();
            //});
        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
            //(new Reputation)->award($thread->creator, Reputation::THREAD_WAS_PUBLISHED);
            Reputation::award($thread->creator, Reputation::THREAD_WAS_PUBLISHED);
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
        return $this->belongsTo(Channel::class)->withoutGlobalScope('active');
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
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
             ->where('user_id', $userId ?: auth()->id())
             ->delete();
    }

    public function isSubscribedTo()
    {
        return $this->subscriptions()
                    ->where('user_id', auth()->id())
                    ->exists();
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

    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
        Reputation::award($reply->owner, Reputation::BEST_REPLY_SELECTED);
    }

    public function getBodyAttribute($body)
    {
        //return $body;
        return \Purify::clean($body);
    }

    public function setSlugAttribute($value)
    {
        $slug = $this->make_slug($value);
        $origin = $slug;
        $count = 2;
        while (static::whereSlug($slug)->exists()) {
            $slug = "{$origin}-".$count++;
        }
        $this->attributes['slug'] = $slug;
    }

    public function make_slug($string)
    {
        $slug = preg_replace('/\s+/u', '-', trim($string));

        return $slug = str_slug($slug);
    }

    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];
    }
}
