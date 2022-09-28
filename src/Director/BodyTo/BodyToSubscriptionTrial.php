<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Entity\SubscriptionTrial;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class BodyToSubscriptionTrial
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public static function build(array $data): SubscriptionTrial
    {
        $trial = (new SubscriptionTrial())
            ->setEndDate(self::date($data, 'end'))
            ->setStartDate(self::date($data, 'start'))
            ->setIsActive($data['is_active']);

        return $trial;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    private static function date(array $data, string $field): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($data[$field]);
        } catch (Exception $e) {
            /** @noinspection JsonEncodingApiUsageInspection */
            $body = (string)json_encode($data, JSON_ERROR_NONE);
            throw new DecodeResponseException($body, $field, $e);
        }
    }
}
