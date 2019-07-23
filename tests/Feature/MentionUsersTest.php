<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function mentioned_user_in_a_reply_should_be_notified()
    {
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);
        
        $jane = create('App\User', ['name' => 'JaneDoe']);
        
        $thread = create('App\Thread');
        
        $reply = create('App\Reply', [
            'body' => '@JaneDoe look at this notify @David',
        ]);
        $this->json('post', $thread->path() . '/replies', $reply->toArray());
        $this->assertCount(1, $jane->notifications);
    }
    
    /** @test */
    public function it_can_fetch_mentioned_users_starting_with_given_characters()
    {
        create('App\User', ['name'=>'JohnDoe']);
        create('App\User', ['name'=>'janeDoe']);
        create('App\User', ['name'=>'JohnDoe2']);
        
        $results = $this->json('get', '/api/users', ['name' => 'john']);
        
        $this->assertCount(2, $results->json());
    }
    
}
