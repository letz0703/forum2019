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
        //$this->actingAs(factory('App\User')->create());
        $this->signIn();
        
        $thread = factory('App\Thread')->make();
        
        // hit the end point
        $this->post('/threads', $thread->toArray());
        
        $this->get($thread->path())
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }
}
