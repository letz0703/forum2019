<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    //

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($reply->thread, $reply));
    }
}
