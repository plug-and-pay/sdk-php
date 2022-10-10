<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Discount;
use PlugAndPay\Sdk\Enum\DiscountType;

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
                ->setAmount((float) $discount['amount'])
                ->setAmountWithTax((float) $discount['amount_with_tax'])
                ->setCode($discount['code'])
                ->setType(DiscountType::from($discount['type']));
        }

        return $result;
    }
}
