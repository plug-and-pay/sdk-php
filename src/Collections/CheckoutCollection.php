<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Collections;

use PlugAndPay\Sdk\Entity\Checkout;

class CheckoutCollection
{
    /**
     * @param array<Checkout> $checkouts
     * @param array<int, string> $meta
     */
    public function __construct(
        public readonly array $checkouts,
        public readonly array $meta,
    ) {
    }
}
