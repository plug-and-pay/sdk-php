<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\PriceTier;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToPriceTier implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    public static function build(array $data): PriceTier
    {
        return (new PriceTier())
            ->setAmount((float) $data['amount'])
            ->setAmountWithTax((float) $data['amount_with_tax'])
            ->setQuantity($data['quantity']);
    }
}
