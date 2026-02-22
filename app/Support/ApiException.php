<?php

namespace App\Support;

use Exception;

class ApiException extends Exception
{
    public function __construct(
        public readonly string $apiCode,
        string $message,
        public readonly int $status = 400
    ) {
        parent::__construct($message);
    }
}
