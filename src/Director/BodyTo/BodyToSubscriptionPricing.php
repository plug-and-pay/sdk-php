<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\SubscriptionPricing;

class BodyToSubscriptionPricing
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public static function build(array $data): SubscriptionPricing
    {
        $subscriptionPricing = (new SubscriptionPricing())
            ->setAmount($data['amount'])
            ->setAmountWithTax($data['amount_with_tax'])
            ->setDiscounts($data['discounts'] ?? [])
            ->setQuantity($data['quantity'])
            ->setTax($data['tax'])
            ->setIsTaxIncluded($data['is_tax_included']);

        return $subscriptionPricing;
    }
}
