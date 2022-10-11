<?php

namespace PlugAndPay\Sdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class ExceptionTest extends TestCase
{
    /** @test */
    public function decode_response_exception(): void
    {
        $exception = new DecodeResponseException('{}', 'lorem');

        static::assertEquals('Can\'t decode lorem from response body. Please contact customer service. Response body: {}', $exception->getMessage());
    }
}