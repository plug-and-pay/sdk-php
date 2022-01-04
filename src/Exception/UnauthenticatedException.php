<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use Exception;

class UnauthenticatedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Unable to connect with Plug&Pay. Request is unauthenticated.');
    }
}
