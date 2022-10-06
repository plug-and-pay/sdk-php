<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PriceRegular;

class PriceRegularToBody
{
    public static function build(PriceRegular $regular): array
    {

        $result = [];

        if ($regular->isset('amount')) {
            $result['amount'] = (string) $regular->amount();
        }

        if ($regular->isset('amountWithTax')) {
            $result['amount_with_tax'] = (string) $regular->amountWithTax();
        }

        return $result;
    }
}
