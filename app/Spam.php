<?php


namespace App;


class Spam
{
    public function detect($body)
    {
        $spamKeyWords = [
            'Yahoo Customer Service'
        ];
    
        foreach ($spamKeyWords as $spamKeyWord){
            if( stripos($body, $spamKeyWord) !== false){
                throw new \Exception('You have spam');
            }
        }
        
        return false;

    }
    
}