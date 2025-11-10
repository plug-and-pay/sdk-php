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
            ->setId($data['id'])
            ->setDefaultRecurring((bool) $data['default_recurring'])
            ->setDefaultType($data['default_type'])
            ->setDefaultValue((float) $data['default_value'])
            ->setDefaultFormValue((float) $data['default_form_value'])
            ->setLabel($data['label'])
            ->setSessionLifetime($data['session_lifetime'])
            ->setTenantId($data['tenant_id']);
    }
}
