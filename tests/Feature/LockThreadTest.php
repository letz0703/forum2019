<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function an_administrator_can_lock_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $thread->lock();
        $this->post($thread->path().'/replies', [
            'body' => 'some text',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}
