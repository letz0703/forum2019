<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_can_subscribe_to_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->subscriptions);
        $this->assertDatabaseHas('subscriptions', ['user_id' => auth()->id()]);
    }
    
    public function a_user_can_unsubscribe_from_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post($thread->path() . '/subscriptions');
        $this->delete($thread->path() . '/subscriptions');
        $this->assertCount(0, $thread->subscriptions);
    }
    
    /** @test */
    public function user_should_be_notified_when_a_subscribed_thread_has_new_reply()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1,
            $thread->subscriptions
        );
        //$this->assertDatabaseHas('subscriptions', [
        //    'thread_id'=> $thread->id,
        //    'user_id'=>auth()->id()]
        //);
        

    }
    
}
