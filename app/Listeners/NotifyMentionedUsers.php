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
        $mentionedUsers = $event->reply->mentionedUsers();
        
        collect($event->reply->mentionedUsers())
            ->map(function($name){
                return User::whereName($name)->first();
            })
            ->filter()
            ->each(function($user) use ($event){
                $user->notify(new YouWereMentioned($event->reply));
            });
        
        //foreach ($mentionedUsers as $name){
        //    $user = User::whereName($name)->first();
        //    //dd($user);
        //    if ($user){
        //        $user->notify(new YouWereMentioned($event->reply));
        //    }
        //}
    }
}
