<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\CustomField;

class BodyToCustomField
{
    public static function build(array $data): CustomField
    {
        return (new CustomField())
            ->setId($data['id'])
            ->setInput($data['input'])
            ->setLabel($data['label']);
    }
}
