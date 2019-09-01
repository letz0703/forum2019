<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_earns_points_when_they_create_a_thread()
    {
        $thread = create('App\Thread');
        $this->assertEquals(10, $thread->creator->reputation);
    }
    
    /** @test */
    public function a_user_earns_points_when_they_reply_to_a_thread()
    {
        $thread = create('App\Thread');
        $reply = create('App\Reply', [
            'user_id' => create('App\User')->id,
            'body'    => 'Some body',
        ]);
        
        $this->assertEquals(2, $reply->owner->reputation);
    }
    
    /** @test */
    public function a_user_earns_points_when_their_reply_is_marked_as_best()
    {
        $thread = create('App\Thread');
        $reply = create('App\Reply', [
            'user_id' => create('App\User')->id,
            'body'    => 'Some body',
        ]);
        
        $thread->markBestReply($reply);
        
        $this->assertEquals(52, $reply->owner->reputation);
    }
    
    
}
