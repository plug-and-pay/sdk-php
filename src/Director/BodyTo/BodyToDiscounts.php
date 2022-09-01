<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Discount;

class BodyToDiscounts
{
    /**
     * @return Discount[]
     */
    public static function buildMany(array $data): array
    {
        $result = [];
        foreach ($data as $discount) {
            $result[] = (new Discount())
                ->setAmount((float)$discount['amount'])
                ->setCode($discount['code'])
                ->setType($discount['type']);
        }
        return $result;
    }
}
