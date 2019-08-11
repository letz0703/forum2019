<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;

class RegistrationConfirmationController extends Controller
{
    public function index()
    {
        User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();
        
        return redirect('/threads')
            ->with('flash', 'Your email is confirmed. Your can post from now on.');
    }
    
}
