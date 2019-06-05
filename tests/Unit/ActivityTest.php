<?php

namespace Tests\Unit;

use App\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);
        $activity = Activity::first();
        //dd($activity->subject->id);
        $this->assertEquals($activity->subject->id, $thread->id);
    }
    
    
}
