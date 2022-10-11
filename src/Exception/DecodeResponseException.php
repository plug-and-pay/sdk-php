<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use Exception;
use Throwable;

/**
 * @codeCoverageIgnore
 * @see \PlugAndPay\Sdk\Tests\Unit\ExceptionTest::decode_response_exception
 */
class DecodeResponseException extends Exception
{
    public function __construct(string $body, $field = '', Throwable $previous = null)
    {
        parent::__construct("Can't decode $field from response body. Please contact customer service. Response body: $body", 0, $previous);
    }
}
