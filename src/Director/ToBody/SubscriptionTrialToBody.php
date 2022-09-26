<?php

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\SubscriptionTrial;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class SubscriptionTrialToBody
{
    /**
     * @throws RelationNotLoadedException
     */
    public static function build(SubscriptionTrial $trial): array
    {
        $result = [];

        if ($trial->isset('endDate')) {
            $result['end'] = $trial->endDate();
        }

        if ($trial->isset('isActive')) {
            $result['is_active'] = $trial->isActive();
        }

        if ($trial->isset('startDate')) {
            $result['start'] = $trial->startDate();
        }

        return $result;
    }
}