<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_notifications_is_prepared_when_a_subscribed_thread_received_a_new_reply()
    {
        $this->signIn();
        
        $thread = create('App\Thread')->subscribe();
        //$thread->addReply([
        //    'user_id' => auth()->id(),
        //    'body'    => 'body'
        //]);
    
        //auth()->user()->notify(new ThreadWasUpdated($thread, $reply));
    
        //$this->assertCount(0, auth()->user()->fresh()->notifications);
    
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'body'
        ]);
        
        $this->assertCount(1, auth()->user()->notifications);
        
    }
}
