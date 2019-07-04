<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_notifications_is_prepared_when_a_subscribed_thread_received_a_new_reply()
    {
        $this->signIn();
        
        $thread = create('App\Thread')->subscribe();
        //$thread->addReply([
        //    'user_id' => auth()->id(),
        //    'body'    => 'body'
        //]);
    
        //auth()->user()->notify(new ThreadWasUpdated($thread, $reply));
    
        //$this->assertCount(0, auth()->user()->fresh()->notifications);
    
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'body'
        ]);
        
        $this->assertCount(1, auth()->user()->notifications);
    }
    
    /** @test */
    public function user_can_fetch_their_unread_notification()
    {
        $this->signIn();
        $thread = create('App\Thread')->subscribe();
        
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'body'
        ]);
        
        
    
        $user = auth()->user();
        $endpoint = "/profiles/{$user->name}/notifications/";
        
        //$response = $this->getJson($endpoint)->json();
        $response = $this->getJson($endpoint)->json();
    
        $this->assertCount(1, $response);
        
    }
    
    
    /** @test */
    public function user_can_mark_their_notification_as_read()
    {
        $this->signIn();
        $thread = create('App\Thread')->subscribe();
        
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'body'
        ]);
        
        $this->assertCount(1, auth()->user()->unreadNotifications);
        
        $user = auth()->user();
        $notificationId = $user->unreadNotifications->first()->id;
        
        $endpoint = "/profiles/{$user->name}/notifications/{$notificationId}";
        
        
        $this->delete($endpoint);
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
    
}
