<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\MembershipsSetting;

class MembershipsSettingToBody
{
    public static function build(MembershipsSetting $rule): array
    {
        $result = [];

        if ($rule->isset('driver')) {
            $result['driver'] = $rule->driver();
        }

        if ($rule->isset('isActive')) {
            $result['is_active'] = $rule->isActive();
        }

        if ($rule->isset('tenantId')) {
            $result['tenant_id'] = $rule->tenantId();
        }

        if ($rule->isset('apiToken')) {
            $result['api_token'] = $rule->apiToken();
        }

        if ($rule->isset('createdAt')) {
            $result['created_at'] = $rule->createdAt();
        }

        return $result;
    }
}
