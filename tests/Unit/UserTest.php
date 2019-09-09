<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_fetch_their_most_recent_reply()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = create('App\Reply', ['user_id'=> auth()->id()]);
        $this->assertEquals(auth()->user()->lastReply->id, $reply->id);
    }
}
