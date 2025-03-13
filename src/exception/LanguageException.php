<?php

namespace Ethanrobins\Chatbridge\Exception;

use Exception;

class LanguageException extends Exception
{
    public function __construct(string $message, int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}