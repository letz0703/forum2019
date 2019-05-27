<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadCreateTest extends TestCase
{
    
    use RefreshDatabase;
    
    /** @test */
    public function guest_may_not_create_thread()
    {
        $this->withExceptionHandling();
        
        $this->get('/threads/create')
             ->assertRedirect('login');
        
        $this->post('/threads')
             ->assertRedirect('login');
    }
    
    /** @test */
    public function au_auth_user_can_create_new_forum_threads()
    {
        $this->signIn();
        
        $thread = factory('App\Thread')->make();
        
        // hit the end point
        $response = $this->post('/threads', $thread->toArray());
        //dd($response->headers->get('Location'));
        
        $this->get($response->headers->get('Location'))
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }
    
    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
             ->assertSessionHasErrors('title');
    }
    
    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
             ->assertSessionHasErrors('body');
    }
    
    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();
        $this->publishThread(['channel_id' => null])
             ->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id'=>999])
             ->assertSessionHasErrors('channel_id');
    }
    
    /** @test */
    public function a_thread_can_be_deleted()
    {
        $this->signIn();
        
        $thread = create('App\Thread');
        $reply = create('App\Reply',['thread_id'=> $thread->id]);
        
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
        //$this->assertDatabaseMissing('threads', $thread->toArray());
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
    
    
    
    public function publishThread($overrides = [])
    {
        $this->signIn()->withExceptionHandling();
        $thread = make('App\Thread', $overrides);
        
        return $this->post('/threads', $thread->toArray());
    }
    
    
    
    
    
    
}
