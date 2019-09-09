<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadReadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads');
        //$response->assertStatus(200);
        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get($thread->path());
        $response->assertSee($thread->title);
    }

    /** @test */
    public function threads_can_be_filtered_by_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/'.$channel->slug)
             ->assertSee($threadInChannel->title)
             ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_user_name()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('/threads?by=JohnDoe')
             ->assertSee($threadByJohn->title)
             ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWith2Replies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWith2Replies->id], 2);

        $threadWith3Replies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWith3Replies->id], 3);

        create('App\Thread');

        $response = $this->getJson('/threads?popular=1')->json();
        //$response->assertSee($threadWith3Replies->title);
        //dd($response);

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
        //$response->assertEquals([3,2,0],  )
    }

    /** @test */
    public function user_can_filter_unanswered_thread()
    {
        create('App\Thread');
        $threadAnswered = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $threadAnswered->id]);

        $response = $this->getJson('/threads?unaswered=1')->json();
        //dd($response);

        $this->assertCount(1, $response['data']);
    }
}
