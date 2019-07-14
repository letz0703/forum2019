<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    /**
     * @param $body
     *
     * @throws Exception
     */
    
    public function detect($body)
    {
        $spamKeyWords = [
            'Yahoo Customer Service',
        ];
    
        foreach ($spamKeyWords as $spamKeyWord){
            if (stripos($body, $spamKeyWord) !== false){
                throw new \Exception('You have spam');
            }
        }
    }
    
    
}