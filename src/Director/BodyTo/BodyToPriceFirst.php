<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\PriceFirst;

class BodyToPriceFirst
{
    public static function build(array $data): PriceFirst
    {
        return (new PriceFirst())
            ->setAmount((float) $data['amount'])
            ->setAmountWithTax((float) $data['amount_with_tax']);
    }
}
