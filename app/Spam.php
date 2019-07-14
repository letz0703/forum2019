<?php


namespace App;


use Exception;

class Spam
{
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);
        $this->detectKeyHeldDown($body);
        
        
        return false;
        
    }
    
    public function detectInvalidKeywords($body)
    {
        $spamKeyWords = [
            'Yahoo Customer Service',
        ];
        
        foreach ($spamKeyWords as $spamKeyWord){
            if (stripos($body, $spamKeyWord) !== false){
                throw new Exception('You have spam');
            }
        }
    }
    
    public function detectKeyHeldDown($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)){
            throw new \Exception('You have keyHeld Down');
        }
    }
}