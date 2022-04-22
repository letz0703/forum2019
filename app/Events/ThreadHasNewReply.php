<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class ThreadHasNewReply
{
    use  SerializesModels;
    public $thread;
    public $reply;

    /**
     * Create a new event instance.
     *
     * @param  \App\Thread  $thread
     * @param  \App\Reply  $reply
     */
    public function __construct($thread, $reply)
    {
        //
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
