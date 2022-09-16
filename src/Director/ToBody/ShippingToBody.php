<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Shipping;

class ShippingToBody
{
    public static function build(Shipping $shipping): array
    {
        return [
            'amount'          => $shipping->amount(),
            'amount_with_tax' => $shipping->amountWithTax(),
        ];
    }
}
