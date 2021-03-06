<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepliesReadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_read_replies_associated_with_a_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id'=>$this->thread->id]);
        //dd($reply->body);
        $this->get($this->thread->path());
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
    }
}
