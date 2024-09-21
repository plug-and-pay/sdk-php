<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use Exception;

class InvalidTokenException extends Exception
{
    public function __construct($message = 'Invalid token')
    {
        parent::__construct($message);
    }
}
