<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Support\Str;

class StringUtilsTest extends TestCase
{
    /** @test */
    public function it_should_generate_correct_string_length(): void
    {
        $this->assertEquals(40, strlen(Str::random(40)));
    }

    /** @test */
    public function it_should_generate_default_string_length(): void
    {
        $this->assertEquals(16, strlen(Str::random()));
    }
}
