<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadReadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads');
        //$response->assertStatus(200);
        $response->assertSee($thread->title);
        
    }
    
    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $thread = factory('App\Thread')->create();
        
        $response = $this->get($thread->path());
        $response->assertSee($thread->title);
        
    }
    
    /** @test */
    public function threads_can_be_filtered_by_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread',['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        
        $this->get('/threads/'.$channel->slug)
             ->assertSee($threadInChannel->title)
             ->assertDontSee($threadNotInChannel->title);
            
    }
    
    
}
