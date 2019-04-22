<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateinForumTest extends TestCase
{
    
    use RefreshDatabase;
    
    
    /** @test */
    public function unauth_user_may_not_participate_in_forum_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        //$thread = factory('App\Thread')->create();
        //$reply = factory('App\Reply')->create();
        
        //$this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
        $this->post('/threads/1/replies',[]);
    }
    
    
    /** @test */
    public function an_auth_user_may_paticipate_in_forum_thread()
    {
        $this->be(factory('App\User')->create());
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make();
        
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
        
        $this->get($thread->path())
             ->assertSee($reply->body);
    }
}
