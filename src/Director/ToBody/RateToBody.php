<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Rate;

class RateToBody
{
    public static function build(Rate $rate): array
    {
        $result = [];

        if ($rate->isset('id')) {
            $result['id'] = $rate->id();
        }

        return $result;
    }
}
