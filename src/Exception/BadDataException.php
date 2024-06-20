<?php

namespace App\Exception;

class BadDataException extends \Exception implements CustomExceptionInterface
{
    public function __construct(string $message = 'Data is not valid', int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
