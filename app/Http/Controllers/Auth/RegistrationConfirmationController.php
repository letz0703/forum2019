<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegistrationConfirmationController extends Controller{
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))->first();
        
        if ( ! $user){
            return redirect(route('threads'))
                ->with('flash', 'Unknown token');
        }
        
        $user->confirm();
        
        return redirect(route('threads'))
            ->with('flash', 'Your email is confirmed. Your can post from now on.');
    }
}
