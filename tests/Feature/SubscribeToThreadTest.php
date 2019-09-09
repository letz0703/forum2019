<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_subscribe_to_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post($thread->path().'/subscriptions');
        $this->assertCount(1, $thread->subscriptions);
        $this->assertDatabaseHas('subscriptions', ['user_id' => auth()->id()]);
    }

    public function a_user_can_unsubscribe_from_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post($thread->path().'/subscriptions');
        $this->delete($thread->path().'/subscriptions');
        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */
    public function user_should_be_notified_when_a_subscribed_thread_has_new_reply()
    {
        $this->signIn();
        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'body',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function user_can_clear_notifications()
    {
        $this->signIn();
        $thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'some body',
        ]);

        $this->assertCount(1, auth()->user()->unreadNotifications);
        //

        $notificationId = auth()->user()->unreadNotifications->first()->id;
        $user = auth()->user();

        $endpoint = "/profiles/{$user->name}/notifications/{$notificationId}";

        $this->delete($endpoint);

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
