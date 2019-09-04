<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function non_administrator_may_not_lock_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->patch($thread->path(), [
            'locked' => true,
        ])->assertStatus(403);
        $this->assertFalse(! ! $thread->fresh()->locked);
    }
    
    /** @test */
    public function an_administrator_can_lock_threads()
    {
        $this->signIn(factory('App\User')->state('administrator')->create());
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->patch($thread->path(), [
            'locked' => true,
        ]);
        $this->assertTrue(!! $thread->fresh()->locked);
    }
}
