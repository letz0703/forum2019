<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadSubscriptionTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');
        $this->signIn();
        $thread->subscribe($userId = 1);
        $this->assertEquals(1,
            $thread->subscriptions()->where('user_id',$userId)->count()
        );
    }
    
    /** @test */
    public function user_can_unsubscribe_from_a_thread()
    {
        $thread = create('App\Thread');
        $this->signIn();
        $thread->subscribe($userId = 1 );
        $this->assertCount(1, $thread->subscriptions);
        $thread->unsubscribe($userId);
        //dd($thread->subscriptions);
        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
    
    /** @test */
    public function thread_knows_if_user_is_subscribed_to()
    {
        $thread = create('App\Thread');
        $this->signIn();
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
        $thread->unsubscribe();
        $this->assertFalse($thread->isSubscribedTo);
    }
    
    
}
