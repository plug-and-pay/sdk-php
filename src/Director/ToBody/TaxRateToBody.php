<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\TaxRate;

class TaxRateToBody
{
    public static function build(TaxRate $rate): array
    {
        $result = [];

        if ($rate->isset('id')) {
            $result['id'] = $rate->id();
        }

        return $result;
    }
}
