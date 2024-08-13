<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\OrderBilling;

class BodyToOrderBilling implements BuildObjectInterface
{
    public static function build(array $data): OrderBilling
    {
        return (new OrderBilling())
            ->setAddress(BodyToAddress::build($data['address']))
            ->setContact(BodyToContact::build($data['contact']));
    }
}
