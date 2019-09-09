<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    /** @test */
    public function an_auth_user_can_unfavorite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');
        $reply->favorite();
        //$this->post('/replies/'.$reply->id.'/favorites');
        //$this->assertCount(1, $reply->favorites);
        $this->delete('/replies/'.$reply->id.'/favorites');
        $this->assertCount(0, $reply->fresh()->favorites);
    }

    /** @test */
    public function an_auth_user_may_only_favorite_once()
    {
        $this->signIn();

        try {
            $reply = create('App\Reply');
            $this->post('/replies/'.$reply->id.'/favorites');
            $this->post('/replies/'.$reply->id.'/favorites');
        } catch (\Exception $e) {
            $this->fail('Do not favorite twice');
        }

        //dd(\App\Favorite::all()->toArray());
        $this->assertCount(1, $reply->favorites);
    }
}
