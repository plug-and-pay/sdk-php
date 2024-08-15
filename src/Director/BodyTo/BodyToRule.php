<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Rule;
use PlugAndPay\Sdk\Entity\RuleInternal;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToRule implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    /**
     * @throws DecodeResponseException
     */
    public static function build(array $data): Rule
    {
        return (new RuleInternal())
            ->setId($data['id'])
            ->setActionType($data['action_type'])
            ->setActionData($data['action_data'])
            ->setTriggerType($data['trigger_type'])
            ->setConditionData($data['condition_data'])
            ->setName($data['name'])
            ->setReadonly($data['readonly'])
            ->setDeletedAt($data['deleted_at'] ? self::date($data, 'deleted_at') : null)
            ->setCreatedAt(self::date($data, 'created_at'))
            ->setUpdatedAt($data['updated_at'] ? self::date($data, 'updated_at') : null)
            ->setDriver($data['driver']);
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
