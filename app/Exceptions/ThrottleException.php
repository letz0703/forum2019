<?php

namespace App\Exceptions;

class ThrottleException extends \Exception
{
    /**
     * ThrottleException constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
