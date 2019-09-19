<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function Confirmation_Email_is_sent_upon_registration()
    {
        Mail::fake();
        event(new Registered(create('App\User')));
        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /** @test */
    public function user_can_fully_confirm_their_email_address()
    {
        $user = factory('App\User')->state('unconfirmed')->create();
        $this->signIn($user);
        $this->assertFalse($user->confirmed);

        $this->get(route('register.confirm', [
            'token' => $user->confirmation_token,
        ]))->assertRedirect(route('threads'));

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->confirmed);
            $this->assertNull($user->confirmation_token);
        });
    }

    /** @test */
    public function redirect_users_when_the_given_token_is_invalid()
    {
        $this->get(route('register.confirm'), ['confirmation_token' => 'invalid'])
             ->assertRedirect(route('threads'))
             ->assertSessionHas('flash', 'Unknown token');
    }
}
