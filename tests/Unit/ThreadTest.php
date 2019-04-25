<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class ThreadTest extends TestCase
{
    
    use RefreshDatabase;
    
    /** @test */
    public function a_thread_has_a_creator()
    {
        $thread = factory('App\Thread')->create();
        
        $this->assertInstanceOf('App\User', $thread->creator);
    }
    
    /** @test */
    public function a_thread_has_replies()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf(Collection::class, $thread->replies);
    }
    
    /** @test */
    public function a_thread_can_add_reply()
    {
        $thread = factory('App\Thread')->create();
        $thread->addReply([
            'user_id' => 1,
            'body'    => 'foobar',
        ]);
        
        $this->assertCount(1, $thread->replies);
    }
    
    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
         $thread = $thread = create('App\Thread');
         $this->assertInstanceOf('App\Channel', $thread->channel);
    }
    
    
    
}
