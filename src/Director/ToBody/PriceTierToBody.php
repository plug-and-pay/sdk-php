<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PriceTier;

class PriceTierToBody
{
    public static function build(PriceTier $first): array
    {
        return [
            'amount'          => $first->amount(),
            'amount_with_tax' => $first->amountWithTax(),
            'quantity'        => $first->quantity(),
        ];
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
