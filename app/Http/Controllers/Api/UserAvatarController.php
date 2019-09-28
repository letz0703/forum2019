<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    /**
     * Store a new user avatar
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'avatar' => ['required', 'image'],
        ]);

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')
                //->storeAs('avatars','avatar.jpg','public')
                                      ->store('avatars', 'public'),
        ]);

        return response([], 204);

        //return back();
    }
}
