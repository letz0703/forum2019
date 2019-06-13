<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create('App\User');
        
        $this->get("/profiles/{$user->name}")
             ->assertSee($user->name);
    }
    
    /** @test */
    public function profiles_display_all_threads_created_by_associated_user()
    {
        $this->signIn();
        $thread = create('App\Thread',['user_id'=>auth()->id()]);
    
        $this->get("/profiles/".auth()->user()->name)
             ->assertSee($thread->title);
    }
    
}
