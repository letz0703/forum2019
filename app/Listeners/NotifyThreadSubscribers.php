<?php

namespace App\Listeners;


use App\Events\ThreadHasNewReply;
use App\Notifications\ThreadReceivedNewReply;
use App\User;

class NotifyThreadSubscribers
{
    /**
     * @param ThreadHasNewReply|ThreadReceivedNewReply $event
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        $thread = $event->reply->thread;
        //$event->thread->notifySubscribers($event->reply);
        $thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each
            ->notify($event->reply);
    }
}
