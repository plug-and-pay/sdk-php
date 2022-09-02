<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Address;
use PlugAndPay\Sdk\Enum\CountryCode;

class BodyToAddress
{
    public static function build(array $data): Address
    {
        return (new Address())
            ->setCity($data['city'])
            ->setCountry($data['country'] ? CountryCode::from($data['country']) : null)
            ->setStreet($data['street'])
            ->setHouseNumber($data['housenumber'])
            ->setZipcode($data['zipcode']);
    }
}
