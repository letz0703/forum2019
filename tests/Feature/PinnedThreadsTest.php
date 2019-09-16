<?php

namespace Tests\Feature;

use App\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PinnedThreadsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function an_administrator_can_pin_threads()
    {
        $this->signInAdmin();
        $thread = create('App\Thread');
        $this->post(route('pinned-thread.store', $thread));
        $this->assertTrue($thread->fresh()->pinned, 'Failed asserting that the thread was pinned');
    }
    
    /** @test */
    public function an_administrator_can_unpin_threads()
    {
        $this->signInAdmin();
        $thread = create('App\Thread',['pinned' => true]);
        $this->delete(route('pinned-thread.destroy', $thread));
        $this->assertFalse($thread->fresh()->pinned, 'Failed asserting that the thread was un-pinned');
    }
    
    ///** @test */
    //public function pinned_threads_are_listed_first()
    //{
    //    $channel = create(Channel::class, [
    //        'name' => 'PHP',
    //        'slug' => 'php'
    //    ]);
    //    create('App\Thread', ['channel_id'=>$channel->id]);
    //    create('App\Thread', ['channel_id'=>$channel->id]);
    //    $threadToPin = create('App\Thread', ['channel->id'=>$channel->id]);
    //
    //}
    //
}
