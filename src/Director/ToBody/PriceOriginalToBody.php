<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PriceOriginal;

class PriceOriginalToBody
{
    public static function build(PriceOriginal $first): array
    {

        $result = [];

        if ($first->isset('amount')) {
            $result['amount'] = (string) $first->amount();
        }

        if ($first->isset('amountWithTax')) {
            $result['amount_with_tax'] = (string) $first->amountWithTax();
        }

        return $result;
    }
}
