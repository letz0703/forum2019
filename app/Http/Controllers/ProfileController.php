<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;

class ProfileController extends Controller
{
    //
    public function show(User $user)
    {
        //return $activities;
        //$threads = Thread::where('user_id', $user->id)->get();
        return view('profiles.show', [
            'profileUser' => $user,
            //'threads' => $user->threads()->paginate(30)
            'activities'  => Activity::feed($user),
            //'activities' => $this->getActivity($user)
        ]);
    }
}
