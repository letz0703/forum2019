<?php

namespace App;

class Reputation
{
    const THREAD_WAS_PUBLISHED = 10;
    const REPLY_WAS_PUBLISHED = 2;
    const BEST_REPLY_SELECTED = 50;
    
    public static function award($user, $points)
    {
        $user->increment('reputation', $points);
    }
    
}

