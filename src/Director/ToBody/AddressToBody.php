<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Address;

class AddressToBody
{
    public static function build(Address $address): array
    {
        $result = [];
        if ($address->isset('country')) {
            $result['country'] = $address->country();
        }
        return $result;
    }
}
