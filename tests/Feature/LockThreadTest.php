<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function non_administrator_may_not_lock_thread()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $thread = create('App\Thread');
        //$this->patch($thread->path(), [
        //'locked' => true,
        $this->post(route('locked-thread.store', $thread))->assertStatus(403);
        $this->assertFalse(! ! $thread->fresh()->locked);
    }
    
    /** @test */
    public function an_administrator_can_lock_threads()
    {
        $this->signIn(factory('App\User')->state('administrator')->create());
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('locked-thread.store', $thread));
        //$this->patch($thread->path(), [
        //    'locked' => true,
        //]);
        $this->assertTrue(! ! $thread->fresh()->locked,
            'Failed Asserting that the thread is locked');
    }
    
    /** @test */
    public function once_locked_a_thread_may_not_receive_new_reply()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $thread->lock();
        self::assertTrue($thread->locked);
        $reply = create('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertStatus(422);
    }
    
}
