<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    
    use RefreshDatabase;
    
    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
             ->post('/replies/1/favorites')
             ->assertRedirect('/login');
    }
    
    /** @test */
    public function an_auth_user_can_favorite_any_reply()
    {
        $this->signIn();
        
        $reply = create('App\Reply');
        $this->post('/replies/'.$reply->id.'/favorites');
        $this->assertCount(1, $reply->favorites);
    }
}
