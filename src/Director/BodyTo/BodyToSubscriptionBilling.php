<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Entity\SubscriptionBilling;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class BodyToSubscriptionBilling
{
    /**
     * @throws DecodeResponseException
     */
    public static function build(array $data): SubscriptionBilling
    {
        $billing = (new SubscriptionBilling(false))
            ->setAddress(BodyToAddress::build($data['address']))
            ->setContact(BodyToContact::build($data['contact']))
            ->setSchedule(BodyToSubscriptionBillingSchedule::build($data['schedule']))
            ->setPaymentOptions(BodyToSubscriptionPaymentOptions::build($data['payment_options']))
        ;

        return $billing;
    }

    /**
     * @return Subscription[]
     * @throws DecodeResponseException
     */
    public static function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $order) {
            $result[] = self::build($order);
        }

        return $result;
    }

    /**
     * @throws DecodeResponseException
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
