<?php

namespace Tests\Unit;

use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_an_owner()
    {
        $reply = factory('App\Reply')->create();
        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');
        $this->assertTrue($reply->wasJustPublished());
        $reply->created_at = \Carbon\Carbon::now()->subMonth();
        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_fetch_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Reply', [
            'body' => '@JoneDoe wants to talk @JaneDoe',
        ]);

        $this->assertEquals(['JoneDoe', 'JaneDoe'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mentioned_user_name_within_anchor_tags()
    {
        //$reply = create('App\Reply',['body' => 'Hello @Jane-Doe']);
        $reply = new Reply(['body' => 'Hello @Jane-Doe']);
        $this->assertEquals(
            "Hello <a href='/profiles/Jane-Doe'>@Jane-Doe</a>",
            $reply->body
        );
    }
}
