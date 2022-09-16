<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Shipping;

class BodyToPricingShipping
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public static function build(array $data): Shipping
    {
        return (new Shipping())
            ->setAmount((float)$data['amount'])
            ->setAmountWithTax((float)$data['amount_with_tax']);
    }
}
