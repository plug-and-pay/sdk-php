<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\SellerProfile;
use PlugAndPay\Sdk\Entity\SellerProfileInternal;

class BodyToSellerProfile implements BuildObjectInterface
{
    public static function build(array $data): SellerProfile
    {
        return (new SellerProfileInternal())
            ->setId($data['id']);
    }
}