<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PriceFirst;

class PriceFirstToBody
{
    public static function build(PriceFirst $first): array
    {
        return [
            'amount'          => (string) $first->amount(),
            'amount_with_tax' => (string) $first->amountWithTax(),
        ];
    }
}
