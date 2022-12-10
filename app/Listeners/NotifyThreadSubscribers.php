<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use App\Notifications\ThreadReceivedNewReply;

class NotifyThreadSubscribers
{
    /**
     * @param  ThreadHasNewReply|ThreadReceivedNewReply  $event
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        //$event->thread->notifySubscribers($event->reply);
        $event->reply->thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each
            ->notify($event->reply);
    }
}
