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
}
