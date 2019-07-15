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
        
        $this->get($thread->path());
        //->assertSee($reply->body);
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $reply->thread->replies_count);
    }
    
    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();
        //$this->signIn();
        
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        
        $this->post($thread->path() . '/replies', $reply->toArray())
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
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->delete("/replies/{$reply->id}")
             ->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
        
    }
    
    /** @test */
    public function unauth_user_cannot_update_reply()
    {
        $this->withExceptionHandling();
        
        $reply = create('App\Reply');
        
        //$this->patch("/replies/{$reply->id}")
        //     ->assertRedirect('login');
        
        $this->signIn()
             ->patch("/replies/{$reply->id}")
             ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        
        
        $str = 'changed reply';
        $this->patch("/replies/{$reply->id}", ['body' => $str]);
        
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $str]);
        
    }
    
    /** @test */
    public function user_can_request_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);
        
        $response = $this->getJson($thread->path() . '/replies')->json();
        //dd($response);
        
        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
    
    /** @test */
    public function reply_can_not_be_created_when_it_has_spam()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = create('App\Reply',[
            'body' => 'Yahoo Customer Service'
        ]);
        
        $this->expectException(\Exception::class);
        $this->post($thread->path() . '/replies', $reply->toArray());
    
    }
    
    
    
}
