<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Billing;

class BodyToBilling
{
    public static function build(array $data): Billing
    {
        return (new Billing())
            ->setAddress(BodyToAddress::build($data['address']))
            ->setCompany($data['company'] ?? '')
            ->setEmail($data['email'])
            ->setFirstName($data['firstname'])
            ->setLastName($data['lastname'])
            ->setTelephone($data['telephone'] ?? '')
            ->setWebsite($data['website'] ?? '');
    }
}
