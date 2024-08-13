<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Entity\SubscriptionInternal;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class BodyToSubscription implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    /**
     * @throws DecodeResponseException
     */
    public static function build(array $data): Subscription
    {
        $subscription = (new SubscriptionInternal(false))
            ->setId($data['id'])
            ->setCancelledAt($data['cancelled_at'] ? self::date($data, 'cancelled_at') : null)
            ->setCreatedAt(self::date($data, 'created_at'))
            ->setDeletedAt($data['deleted_at'] ? self::date($data, 'deleted_at') : null)
            ->setStatus(SubscriptionStatus::from($data['status']))
            ->setMode(Mode::from($data['mode']))
            ->setSource(Source::tryFrom($data['source'] ?? '') ?? Source::UNKNOWN);

        if (isset($data['trial'])) {
            $subscription->setTrial($data['trial'] ? BodyToSubscriptionTrial::build($data['trial']) : null);
        }

        if (isset($data['billing'])) {
            $subscription->setBilling(BodyToSubscriptionBilling::build($data['billing']));
        }

        if (isset($data['product'])) {
            $subscription->setProduct(BodyToProduct::build($data['product']));
        }

        if (isset($data['pricing'])) {
            $subscription->setPricing(BodyToSubscriptionPricing::build($data['pricing']));
        }

        if (isset($data['tags'])) {
            $subscription->setTags($data['tags']);
        }

        return $subscription;
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
     * @codeCoverageIgnore
     */
    private static function date(array $data, string $field): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($data[$field]);
        } catch (Exception $e) {
            /** @noinspection JsonEncodingApiUsageInspection */
            $body = (string) json_encode($data, JSON_ERROR_NONE);
            throw new DecodeResponseException($body, $field, $e);
        }
    }
}
