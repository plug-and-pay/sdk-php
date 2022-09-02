<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Address;

class AddressToBody
{
    public static function build(Address $address): array
    {
        $result = [];
        if ($address->isset('city')) {
            $result['city'] = $address->city();
        }

        if ($address->isset('country')) {
            $result['country'] = $address->country()?->value;
        }

        if ($address->isset('houseNumber')) {
            $result['housenumber'] = $address->houseNumber();
        }

        if ($address->isset('street')) {
            $result['street'] = $address->street();
        }

        if ($address->isset('zipcode')) {
            $result['zipcode'] = $address->zipcode();
        }

        return $result;
    }
}
