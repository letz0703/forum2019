<?php


namespace App\Inspections;


use App\Inspections\InvalidKeywords;
use Exception;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];
    
    public function detect($body)
    {
        foreach ($this->inspections as $inspection){
            app($inspection)->detect($body);
        }
    
        return false;
    }
}