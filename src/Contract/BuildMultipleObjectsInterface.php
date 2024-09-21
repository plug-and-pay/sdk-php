<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

interface BuildMultipleObjectsInterface
{
    public static function buildMulti(array $data): array;
}
