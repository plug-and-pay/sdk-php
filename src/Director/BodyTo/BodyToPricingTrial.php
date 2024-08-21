<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\PricingTrial;

class BodyToPricingTrial implements BuildObjectInterface
{
    public static function build(array $data): PricingTrial
    {
        return (new PricingTrial())
            ->setAmount((float) $data['amount'])
            ->setAmountWithTax((float) $data['amount_with_tax'])
            ->setDuration($data['duration']);
    }
}
