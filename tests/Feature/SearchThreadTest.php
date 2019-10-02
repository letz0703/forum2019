<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchThreadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_can_search_threads()
    {
        //config(['scout.driver' => 'algolia']);
        //
        //$search = "foobar";
        //$thread = create('App\Thread', [], 2);
        //$thread = create('App\Thread', ['title' => "{$search}", 'body' => "A thread with {$search} term."], 2);
        //
        //do {
        //    usleep(25000);
        //    $results = $this->getJson("/threads/search?q={$search}")->json();
        //} while (empty($results));
        //
        //$this->assertCount(2, $results['data']);
        //
        //Thread::latest()->take(4)->unsearchable();
        //
    }
}
