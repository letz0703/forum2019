<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

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
        $this->signIn(create('App\User',['name'=>'John']));
        $this->post('/register', [
            'name'                  => 'John',
            'email'                 => 'john@john.com',
            'password'              => 'foobar',
            //'password_confirmation' => 'foobar',
        ]);
        
        $user = User::whereName('John')->first();
        //dd($user->confirmed);
        $this->assertFalse($user->confirmed);
        //dd($user->confirmation_token);
        $this->assertNotNull($user->confirmation_token);
    }
    
}
