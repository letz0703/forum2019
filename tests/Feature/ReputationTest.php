<?php

namespace Tests\Feature;

use App\Reputation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_earns_points_when_they_create_a_thread()
    {
        $thread = create('App\Thread');
        $this->assertEquals(Reputation::THREAD_WAS_PUBLISHED, $thread->creator->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_they_delete_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->assertEquals(Reputation::THREAD_WAS_PUBLISHED, $thread->creator->reputation);
        $this->delete($thread->path());
        $total = Reputation::THREAD_WAS_PUBLISHED - Reputation::THREAD_WAS_PUBLISHED;
        self::assertEquals(0, auth()->user()->fresh()->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_they_reply_to_a_thread()
    {
        $thread = create('App\Thread');
        $reply = create('App\Reply', [
            'user_id' => create('App\User')->id,
            'body'    => 'Some body',
        ]);

        $this->assertEquals(Reputation::REPLY_WAS_PUBLISHED, $reply->owner->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_their_reply_to_a_thread_is_deleted()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->assertEquals(Reputation::REPLY_WAS_PUBLISHED, $reply->owner->reputation);
        $this->delete("/replies/{$reply->id}");
        $total = Reputation::REPLY_WAS_PUBLISHED - Reputation::REPLY_WAS_PUBLISHED;
        $this->assertEquals($total, $reply->owner->fresh()->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_their_reply_is_marked_as_best()
    {
        $thread = create('App\Thread');
        $reply = create('App\Reply', [
            'user_id' => create('App\User')->id,
            'body'    => 'Some body',
        ]);

        $thread->markBestReply($reply);
        $total = Reputation::BEST_REPLY_SELECTED + Reputation::REPLY_WAS_PUBLISHED;
        $this->assertEquals($total, $reply->owner->fresh()->reputation);
    }

    /** @test */
    public function users_earns_points_when_their_reply_is_favorited()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->post("/replies/{$reply->id}/favorites");
        $points = Reputation::REPLY_IS_FAVORITED + Reputation::REPLY_WAS_PUBLISHED;
        $this->assertEquals($points, $reply->owner->fresh()->reputation);
    }

    /** @test */
    public function users_loses_points_when_their_reply_is_unfavored()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->post("/replies/{$reply->id}/favorites");
        $points = Reputation::REPLY_IS_FAVORITED + Reputation::REPLY_WAS_PUBLISHED;
        $this->assertEquals($points, $reply->owner->fresh()->reputation);
        $this->delete("/replies/{$reply->id}/favorites");
        $points = Reputation::REPLY_IS_FAVORITED + Reputation::REPLY_WAS_PUBLISHED - Reputation::REPLY_IS_FAVORITED;
        $this->assertEquals($points, $reply->owner->fresh()->reputation);
    }
}
