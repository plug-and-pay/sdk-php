<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\SubscriptionPricing;

class BodyToSubscriptionPricing implements BuildObjectInterface
{
    public static function build(array $data): SubscriptionPricing
    {
        $subscriptionPricing = (new SubscriptionPricing())
            ->setAmount((float) $data['amount'])
            ->setAmountWithTax((float) $data['amount_with_tax'])
            ->setDiscounts($data['discounts'] ?? [])
            ->setQuantity($data['quantity'])
            ->setIsTaxIncluded($data['is_tax_included']);

        if (isset($data['tax'])) {
            $subscriptionPricing->setTax(BodyToTax::build($data['tax']));
        }

        return $subscriptionPricing;
    }
}
