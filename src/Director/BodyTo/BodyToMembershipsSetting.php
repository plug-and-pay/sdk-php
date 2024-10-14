<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\MembershipsMembershipsSettingInternal;
use PlugAndPay\Sdk\Entity\MembershipsSetting;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToMembershipsSetting implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    /** @throws DecodeResponseException */
    public static function build(array $data): MembershipsSetting
    {
        return (new MembershipsMembershipsSettingInternal())
            ->setId($data['id'])
            ->setDriver($data['driver'])
            ->setIsActive($data['is_active'])
            ->setTenantId($data['tenant_id'])
            ->setApiToken($data['api_token'])
            ->setCreatedAt(self::date($data, 'created_at'))
            ->setUpdatedAt($data['updated_at'] ? self::date($data, 'updated_at') : null);
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
            $body = (string)json_encode($data, JSON_ERROR_NONE);
            throw new DecodeResponseException($body, $field, $e);
        }
    }
}
