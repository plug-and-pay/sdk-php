<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Discount;
use PlugAndPay\Sdk\Entity\Money;

class BodyToDiscounts
{
    /**
     * @return Discount[]
     */
    public static function build(array $data): array
    {
        $result = [];
        foreach ($data as $discount) {
            $result[] = (new Discount())
                ->setAmount(new Money($discount['amount']))
                ->setCode($discount['code'])
                ->setType($discount['type']);
        }
        return $result;
    }
}
