<?php

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\SubscriptionTrial;

class SubscriptionTrialToBody
{
    public static function build(SubscriptionTrial $trial): array
    {
        $result = [];

        if ($trial->isset('endDate')) {
            $result['end'] = $trial->endDate()->format('Y-m-d');
        }

        if ($trial->isset('isActive')) {
            $result['is_active'] = $trial->isActive();
        }

        if ($trial->isset('startDate')) {
            $result['start'] = $trial->startDate()->format('Y-m-d');
        }

        return $result;
    }
}