<?php

namespace App\Listeners;

use App\Notifications\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply $event
     *
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
        //dd($users);
        //$mentionedUsers = $event->reply->mentionedUsers();

        //foreach ($mentionedUsers as $name){
        //    $user = User::whereName($name)->first();
        //    //dd($user);
        //    if ($user){
        //        $user->notify(new YouWereMentioned($event->reply));
        //    }
        //}
    }
}
