<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\SubscriptionTrial;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Support\DateUtils;

class BodyToSubscriptionTrial implements BuildObjectInterface
{
    /**
     * @throws DecodeResponseException
     */
    public static function build(array $data): SubscriptionTrial
    {
        return (new SubscriptionTrial())
            ->setEndDate(DateUtils::extractDate($data, 'end'))
            ->setStartDate(DateUtils::extractDate($data, 'start'))
            ->setIsActive($data['is_active']);
    }
}
