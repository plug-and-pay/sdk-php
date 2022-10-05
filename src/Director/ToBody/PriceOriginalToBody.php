<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PriceOriginal;

class PriceOriginalToBody
{
    public static function build(PriceOriginal $first): array
    {
        return [
            'amount'          => $first->amount(),
            'amount_with_tax' => $first->amountWithTax(),
        ];
    }
}
