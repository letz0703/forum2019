<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ThreadReceivedNewReply
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reply;
    /**
     * ThreadReceivedNewReply constructor.
     *
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    //public function broadcastOn()
    //{
    //    return new PrivateChannel('channel-name');
    //}
}
