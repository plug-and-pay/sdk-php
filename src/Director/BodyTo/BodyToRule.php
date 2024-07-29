<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Rule;
use PlugAndPay\Sdk\Entity\RuleInternal;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class BodyToRule
{
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
            ->setDeletedAt($data['deleted_at'])
            ->setCreatedAt($data['created_at'])
            ->setUpdatedAt($data['updated_at'])
            ->setDriver($data['driver']);
    }

    /**
     * @return Rule[]
     */
    public static function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $rule) {
            $result[] = self::build($rule);
        }

        return $result;
    }
}