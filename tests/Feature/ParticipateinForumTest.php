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
        //$this->expectException('Illuminate\Auth\AuthenticationException');
        //$thread = factory('App\Thread')->create();
        //$reply = factory('App\Reply')->create();
        
        
        $this->withExceptionHandling()
             ->post('/threads/some-channel/1/replies', [])
             ->assertRedirect('login');
    }
    
    
    /** @test */
    public function an_auth_user_may_paticipate_in_forum_thread()
    {
        $this->be(factory('App\User')->create());
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);
        
        $this->post($thread->path() . '/replies', $reply->toArray());
        
        $this->get($thread->path())
             ->assertSee($reply->body);
    }
    
    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn()->withExceptionHandling();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        
        $this->post($thread->path() .'/replies', $reply->toArray())
             ->assertSessionHasErrors('body');
    }
    
    /** @test */
    public function unauth_user_cannot_delete_reply()
    {
        $this->withExceptionHandling();
        
        $reply = create('App\Reply');
        
        $this->delete("/replies/{$reply->id}")
             ->assertRedirect('login');
        
        $this->signIn()
             ->delete("/replies/{$reply->id}")
             ->assertStatus(403);
    }
    
    
    /** @test */
    public function auth_user_can_delete_thread()
    {
        $this->signIn();
        $reply = create('App\Reply',['user_id'=>auth()->id()]);
        $this->delete("/replies/{$reply->id}")
             ->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        
    }
    
    
}
