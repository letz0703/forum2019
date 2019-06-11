<?php

namespace App\Http\Controllers;

use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function show(User $user)
    {
        $activities =  $user->activity()->with('subject')->latest()->get()
        ->groupBy(function($activity){
            return $activity->created_at->format('Y-m-d');
        });
        //return $activities;
        //$threads = Thread::where('user_id', $user->id)->get();
        return view('profiles.show',[
            'profileUser' => $user,
            //'threads' => $user->threads()->paginate(30)
            'activities' => $activities
        ]);
    }
    
}
