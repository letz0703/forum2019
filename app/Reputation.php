<?php

namespace App;

class Reputation
{
    const THREAD_WAS_PUBLISHED = 10;
    const REPLY_WAS_PUBLISHED = 2;
    const BEST_REPLY_SELECTED = 50;
    const REPLY_IS_FAVORITED = 5;

    public static function award($user, $points)
    {
        $user->increment('reputation', $points);
    }

    public static function swipe($user, $points)
    {
        $user->decrement('reputation', $points);
    }
}
