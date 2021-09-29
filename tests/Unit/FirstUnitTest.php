<?php

declare(strict_types=1);

namespace Unit;

use PHPUnit\Framework\TestCase;

class FirstUnitTest extends TestCase
{
    /** @test */
    public function first_unit_test(): void
    {
        static::assertTrue(true);
    }
}
