<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Support\Parameters;

class ParametersTest extends TestCase
{
    /** @test */
    public function empty_parameter(): void
    {
        static::assertSame('', Parameters::toString([]));
    }

    /** @test */
    public function one_parameter(): void
    {
        static::assertSame('include=hello', Parameters::toString(['include' => 'hello']));
    }

    /** @test */
    public function multiple_parameters(): void
    {
        static::assertSame('first=value1&second=value2', Parameters::toString(['first' => 'value1', 'second' => 'value2']));
    }

    /** @test */
    public function multiple_values(): void
    {
        static::assertSame('include=hello,world', Parameters::toString(['include' => ['hello', 'world']]));
    }
}
