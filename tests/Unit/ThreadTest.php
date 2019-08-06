<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    
    use RefreshDatabase;
    
    /** @test */
    public function a_thread_has_a_creator()
    {
        $thread = factory('App\Thread')->create();
        
        $this->assertInstanceOf('App\User', $thread->creator);
    }
    
    /** @test */
    public function a_thread_has_replies()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf(Collection::class, $thread->replies);
    }
    
    /** @test */
    public function a_thread_can_add_reply()
    {
        $thread = factory('App\Thread')->create();
        $thread->addReply([
            'user_id' => 1,
            'body'    => 'foobar',
        ]);
        
        $this->assertCount(1, $thread->replies);
    }
    
    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
         $thread = $thread = create('App\Thread');
         $this->assertInstanceOf('App\Channel', $thread->channel);
    }
    
    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        
        $this->assertEquals($thread->path(), "/threads/{$thread->channel->slug}/{$thread->id}");
    }
    
    /** @test */
    public function thread_can_check_auth_user_have_read_all_replies()
    {
        $this->signIn();
        $thread = create('App\Thread');
        tap( auth()->user(), function($user) use ($thread){
            $this->assertTrue($thread->hasUpdatesFor($user));
            // visit the thread page
            cache()->forever($user->visitedThreadCacheKey($thread), \Carbon\Carbon::now());
            $this->assertFalse($thread->hasUpdatesFor($user));
        });

    }
    
    /** @test */
    public function it_records_each_visit()
    {
        $thread = make('App\Thread', ['id' => 1]);
        $thread->resetVisits();
        $thread->recordVisit();
        $this->assertEquals(1, $thread->visits());
        $thread->recordVisit();
        $this->assertEquals(2, $thread->visits());
    }
    
    
}
