<?php

namespace App\Listeners;


use App\Events\ThreadHasNewReply;

class NotifyThreadSubscribers
{
    /**
     * @param ThreadHasNewReply $event
     */
    public function handle(ThreadHasNewReply $event)
    {
        $event->thread->notifySubscribers($event->reply);
        //$event->thread->subscriptions
        //     ->where('user_id','!=', $event->reply->user_id)
        //     ->each
        //     ->notify($event->reply);
    }
}
