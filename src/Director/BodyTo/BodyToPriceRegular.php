<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\PriceRegular;

class BodyToPriceRegular
{
    public static function build(array $data): PriceRegular
    {
        return (new PriceRegular())
            ->setAmount((float) $data['amount'])
            ->setAmountWithTax((float) $data['amount_with_tax']);
    }
}
