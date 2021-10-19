<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Address;

class ResponseToAddress
{
    public function build(array $data): Address
    {
        return (new Address())
            ->setCity($data['city'])
            ->setCountry($data['country'])
            ->setStreet($data['street'])
            ->setStreetSuffix($data['street_suffix'])
            ->setZipcode($data['zipcode']);
    }
}
