<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Billing;

class BillingToBody
{
    public static function build(Billing $billing): array
    {
        $result = [];

        if ($billing->isset('address')) {
            $result['address'] = AddressToBody::build($billing->address());
        }

        if ($billing->isset('email')) {
            $result['email'] = $billing->email();
        }

        if ($billing->isset('firstName')) {
            $result['first_name'] = $billing->firstName();
        }

        if ($billing->isset('lastName')) {
            $result['last_name'] = $billing->lastName();
        }

        return $result;
    }
}
