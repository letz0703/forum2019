<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        Redis::del('trending_threads');
    }
    
    /** @test */
    public function it_scores_thread_trending_each_time_a_thread_is_read()
    {
        $this->assertEmpty(Redis::zrevrange('trending_threads', 0, -1));
        $thread = create('App\Thread');
        $this->call('GET', $thread->path());
        $trending = Redis::zrevrange('trending_threads', 0, -1);
        $this->assertCount(1, $trending);
        //dd($trending);
        $this->assertEquals($thread->title, json_decode($trending[0])->title);
    }
}
