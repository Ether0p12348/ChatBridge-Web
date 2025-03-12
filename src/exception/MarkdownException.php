<?php

namespace Ethanrobins\Chatbridge\Exception;

use Exception;

class MarkdownException extends Exception
{
    private string $details;

    public function __construct(string $message, int $code = 0, Exception $previous = null, $details = null)
    {
        parent::__construct($message, $code, $previous);
        http_response_code($code == 0 ? 200 : $code);
        $this->details = $details;
    }

    public function getDetails(): string
    {
        return $this->details;
    }
}