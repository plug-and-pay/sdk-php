<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Money;

class MoneyToBody
{
    public static function build(Money $money): array
    {
        return [
            'value'    => (string)$money->value(),
            'currency' => $money->currency(),
        ];
    }
}
