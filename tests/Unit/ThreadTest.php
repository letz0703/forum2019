<?php

namespace Tests\Unit;

use App\Thread;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use RefreshDatabase;
    //use DatabaseMigrations;

    /** @test */
    public function a_thread_has_a_creator()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\User', $thread->creator);
    }

    /** @test */
    public function a_thread_has_a_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals($thread->path(), "/threads/{$thread->channel->slug}/{$thread->slug}");
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
    public function thread_can_check_auth_user_have_read_all_replies()
    {
        $this->signIn();
        $thread = create('App\Thread');
        tap(auth()->user(), function ($user) use ($thread) {
            $this->assertTrue($thread->hasUpdatesFor($user));
            // visit the thread page
            cache()->forever($user->visitedThreadCacheKey($thread), Carbon::now());
            $this->assertFalse($thread->hasUpdatesFor($user));
        });
    }
    
    /** @test */
    public function a_thread_body_is_sanitised_automatically()
    {
        $thread = make('App\Thread', ['body' => '<script>alert("bad")</script><p>This is ok</p>']);
        //dd($thread->body);
        $this->assertEquals("<p>This is ok</p>", $thread->body);
        //$this->assertEmpty($thread->body);
    }
    

    /** @test */
    public function it_records_each_visit()
    {
        $thread = make('App\Thread', ['id' => 1]);
        $thread->visits()->reset();
        $this->assertSame(0, $thread->visits()->count());
        $thread->visits()->record();
        $this->assertEquals(1, $thread->visits()->count());
        $thread->visits()->record();
        $this->assertEquals(2, $thread->visits()->count());
    }


    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();
        $thread = create('App\Thread', ['title' => 'Foo title']);
        $this->assertEquals('foo-title', $thread->slug);
        $thread = create('App\Thread', ['title' => 'Foo title']);
        $this->assertEquals($thread->fresh()->slug, 'foo-title-2');
        $this->post(route('threads'), $thread->toArray()+['g-recaptcha-response'=>'token']);
        $this->assertDatabaseHas('threads', ['slug'=>'foo-title-2']);
        $this->assertTrue(Thread::whereSlug('foo-title-2')->exists());
        $this->post(route('threads'), $thread->toArray()+['g-recaptcha-response'=>'token']);
        $this->assertTrue(Thread::whereSlug('foo-title-3')->exists());
    }

    /** @test */
    public function thread_title_ends_with_number_should_have_proper_thread()
    {
        $this->signIn();
        $thread = create('App\Thread', ['title' => 'Foo Title 1', 'slug' => 'foo-title-1']);
        $this->post(route('threads'), $thread->toArray()+['g-recaptcha-response' => 'token']);
        $this->assertTrue(Thread::whereSlug('foo-title-1-2')->exists());
    }

    /** @test */
    public function it_knows_best_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->assertFalse($reply->isBest());
        $reply->thread->update(['best_reply_id'=>$reply->id]);
        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    public function it_can_be_locked()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->assertFalse($thread->locked);
        $thread->update(['locked' => true]);
        $this->assertTrue($thread->locked);
    }
}
