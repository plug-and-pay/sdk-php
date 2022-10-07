<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\PriceTier;

class BodyToPriceTier
{
    public static function build(array $data): PriceTier
    {
        return (new PriceTier())
            ->setAmount((float) $data['amount'])
            ->setAmountWithTax((float) $data['amount_with_tax'])
            ->setQuantity($data['quantity']);
    }

    /**
     * @return PriceTier[]
     */
    public static function buildMulti(array $data): array
    {
        $tiers = [];
        foreach ($data as $tier) {
            $tiers[] = self::build($tier);
        }

        return $tiers;
    }
}
