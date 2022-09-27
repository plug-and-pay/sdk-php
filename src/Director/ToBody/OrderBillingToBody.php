<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\OrderBilling;

class OrderBillingToBody
{
    public static function build(OrderBilling $billing): array
    {
        $result = [];

        if ($billing->isset('address')) {
            $result['address'] = AddressToBody::build($billing->address());
        }

        if ($billing->isset('contact')) {
            $result['contact'] = ContactToBody::build($billing->contact());
        }

        return $result;
    }
}
