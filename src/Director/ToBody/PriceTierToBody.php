<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PriceTier;

class PriceTierToBody
{
    public static function build(PriceTier $first): array
    {
        $result = [];

        if ($first->isset('amount')) {
            $result['amount'] = (string) $first->amount();
        }

        if ($first->isset('amountWithTax')) {
            $result['amount_with_tax'] = (string) $first->amountWithTax();
        }

        if ($first->isset('quantity')) {
            $result['quantity'] = $first->quantity();
        }

        return $result;
    }

    /**
     * @param PriceTier[] $tiers
     */
    public static function buildMulti(array $tiers): array
    {
        $result = [];
        foreach ($tiers as $tier) {
            $result[] = self::build($tier);
        }

        return $result;
    }
}
