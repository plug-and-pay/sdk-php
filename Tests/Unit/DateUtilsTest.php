<?php

namespace PlugAndPay\Sdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Support\DateUtils;

class DateUtilsTest extends TestCase
{
    /** @test */
    public function it_should_return_true_if_date_is_valid(): void
    {
        $dateTime = DateUtils::validateDate('2024-08-01 23:59:59');

        $this->assertTrue($dateTime);
    }

    /** @test */
    public function it_should_return_false_if_date_is_not_valid(): void
    {
        // The reason because itsn't valid is bebause we are missing the timestamp
        $date = DateUtils::validateDate('2024-08-01');

        $this->assertFalse($date);
    }

    /** @test */
    public function it_should_return_true_if_the_date_format_changes(): void
    {
        $dateTime = DateUtils::validateDate('01-08-2024', 'd-m-Y');

        $this->assertTrue($dateTime);
    }
}
