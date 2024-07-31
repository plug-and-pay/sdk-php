<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Rule;

class RuleToBody
{
    public static function build(Rule $rule): array
    {
        $result = [];

        if ($rule->isset('actionType')) {
            $result['action_type'] = $rule->actionType();
        }

        if ($rule->isset('actionData')) {
            $result['action_data'] = $rule->actionData();
        }

        if ($rule->isset('triggerType')) {
            $result['trigger_type'] = $rule->triggerType();
        }

        if ($rule->isset('conditionData')) {
            $result['condition_data'] = $rule->conditionData();
        }

        if ($rule->isset('name')) {
            $result['name'] = $rule->name();
        }

        if ($rule->isset('driver')) {
            $result['driver'] = $rule->driver();
        }

        return $result;
    }
}
