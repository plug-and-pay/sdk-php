<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Discount;
use PlugAndPay\Sdk\Enum\DiscountType;

class BodyToDiscounts implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    public static function build(array $discount): Discount
    {
        return (new Discount())
            ->setAmount((float) $discount['amount'])
            ->setAmountWithTax((float) $discount['amount_with_tax'])
            ->setCode($discount['code'])
            ->setType(DiscountType::from($discount['type']));

        (new Discount())
                ->setAmount((float) $discount['amount'])
                ->setAmountWithTax((float) $discount['amount_with_tax'])
                ->setCode($discount['code'])
                ->setType(DiscountType::from($discount['type']));
    }

    /**
     * @return Discount[]
     * @throws Exception
     */
    public static function buildMulti(array $discounts): array
    {
        $result = [];
        foreach ($discounts as $discount) {
            $result[] = self::build($discount);
        }

        return $result;
    }
}
