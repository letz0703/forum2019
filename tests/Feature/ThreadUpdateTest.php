<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ThreadUpdateTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_thread_requires_a_title_and_a_body_to_be_updated()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $thread = create('App\Thread',['user_id'=> auth()->id()]);
        $this->patch($thread->path(), [ 'body' => 'changed body'])
             ->assertSessionHasErrors('title');
    }
    
    /** @test */
    public function only_the_creator_can_update_the_thread()
    {
        $this->withExceptionHandling();
        $this->signIn();
        // given we have a thread
        $thread = create('App\Thread', ['user_id' => create('App\User')->id]);
        
        // User hit the endpoint for updating
        $this->patch($thread->path(), [
            'title' => 'changed',
            'body'  => 'changed',
        ])->assertStatus(403);
    }
    
    /** @test */
    public function a_thread_can_be_updated_by_the_creator()
    {
        $this->signIn();
        // given we have a thread
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        
        // User hit the endpoint for updating
        $this->patchJson($thread->path(), [
            'title' => 'changed',
            'body'  => 'changed',
        ]);
        
        $this->assertEquals('changed', $thread->fresh()->title);
    }
}
