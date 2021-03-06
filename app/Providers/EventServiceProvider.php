<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\NotifyThreadSubscribers;
use App\Notifications\ThreadReceivedNewReply;
use App\Listeners\SendEmailConfirmationRequest;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ThreadReceivedNewReply::class => [
            NotifyMentionedUsers::class,
            NotifyThreadSubscribers::class,
        ],
        Registered::class =>[
            SendEmailConfirmationRequest::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
