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
            ->setContact(BodyToContact::build($data['contact']));
    }
}
