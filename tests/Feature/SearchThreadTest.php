<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchThreadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_can_search_threads()
    {
        $search = "foobar";
        $thread = create('App\Thread', [], 2);
        $thread = create('App\Thread', ['body' => "A thread with {$search} term."], 2);
        $results = $this->getJson("/threads/search?q={$search}")->json();
        //dd($results);
        $this->assertCount(2, $results['data']);
    }
}
