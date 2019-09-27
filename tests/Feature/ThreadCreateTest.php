<?php

namespace Tests\Feature;

use App\Activity;
use App\Rules\Recaptcha;
use App\Thread;
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
    public function new_users_must_confirm_their_email_before_creating_a_thread()
    {
        $user = factory('App\User')->state('unconfirmed')->create();
        $this->signIn($user);
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray())
             ->assertRedirect('/threads')
             ->assertSessionHas('flash', 'You must confirm your email');
    }
    
    /** @test */
    public function an_auth_user_can_create_new_forum_threads()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();
        // hit the end point
        $response = $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
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
        $this->publishThread(['channel_id' => 999])
             ->assertSessionHasErrors('channel_id');
    }
    
    /** @test */
    public function a_thread_can_be_updated()
    {
        $this->signIn();
        // given we have a thread
        $thread = create('App\Thread',['user_id' => auth()->id()]);
        
        // User hit the endpoint for updating
        $this->patchJson($thread->path(),[
            'title' => 'changed',
            'body' => 'changed'
        ]);
        
        $this->assertEquals('changed', $thread->fresh()->title);
    }
    public function unauthorized_user_may_not_delete_threads()
    {
        $this->withExceptionHandling();
        $thread = create('App\Thread');
        $this->delete($thread->path())->assertRedirect('login');
        
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }
    
    /** @test */
    public function an_authorized_user_can_delete_threads()
    {
        $this->signIn();
        
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);
        
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
        //$this->assertDatabaseMissing('threads', $thread->toArray());
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        
        $this->assertEquals(0, Activity::count());
        //$this->assertDatabaseMissing('activities', [
        //    'subject_id' => $thread->id,
        //    'subject_type' => get_class($thread)
        //]);
        //$this->assertDatabaseMissing('activities', [
        //    'subject_id' => $reply->id,
        //    'subject_type' => get_class($reply)
        //]);
    }
    
    /** @test */
    public function a_new_thread_cannot_be_created_in_an_archived_channel()
    {
        $channel = create('App\Channel', ['archived' => true]);
        
        //$response  = $this->publishThread([
        //    'title' => 'Some Title',
        //    'body' => 'Some body',
        //]);
        //
        //$this->get($response->headers->get('Location'))
        //     ->assertSee('Some Title')
        //     ->assertSee('Some body');
        $this->assertCount(0, $channel->threads);
        
        $this->publishThread(['channel_id' => $channel->id])
             ->assertSessionHasErrors('channel_id');
        $this->assertEquals(0, Thread::count());
    }
    
    /** @test */
    public function a_thread_requires_recaptcha_verification()
    {
        unset(app()[ Recaptcha::class ]);
        
        $this->publishThread(['g-recaptcha-response' => 'test'])
             ->assertSessionHasErrors('g-recaptcha-response');
    }
    
    public function publishThread($overrides = [])
    {
        $this->signIn()->withExceptionHandling();
        $thread = make('App\Thread', $overrides);
        
        return $this->post('/threads', $thread->toArray());
    }
    
    
}
