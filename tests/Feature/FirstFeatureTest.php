<?php

declare(strict_types=1);

namespace Feature;

use PHPUnit\Framework\TestCase;
use Support\FirstHelper;

class FirstFeatureTest extends TestCase
{
    /** @test */
    public function first_feature_test(): void
    {
        static::assertEquals('hello', FirstHelper::hello());
    }
}
