<?php

namespace App\Inspections;

class KeyHeldDown
{
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)){
            throw new \Exception('You have keyHeld Down');
        }
    }
    
}