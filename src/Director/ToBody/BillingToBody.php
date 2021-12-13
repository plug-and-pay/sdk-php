<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Billing;

class BillingToBody
{
    public static function build(Billing $billing): array
    {
        $result = [];

        if ($billing->isset('address')) {
            $result['address'] = AddressToBody::build($billing->address());
        }

        if ($billing->isset('company')) {
            $result['company'] = $billing->company();
        }

        if ($billing->isset('email')) {
            $result['email'] = $billing->email();
        }

        if ($billing->isset('firstName')) {
            $result['firstname'] = $billing->firstName();
        }

        if ($billing->isset('lastName')) {
            $result['lastname'] = $billing->lastName();
        }

        if ($billing->isset('telephone')) {
            $result['telephone'] = $billing->telephone();
        }

        if ($billing->isset('website')) {
            $result['website'] = $billing->website();
        }

        return $result;
    }
}
