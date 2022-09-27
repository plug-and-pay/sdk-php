<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\SubscriptionBillingSchedule;

class SubscriptionBillingScheduleToBody
{
    public static function build(SubscriptionBillingSchedule $schedule): array
    {
        $result = [];

        if ($schedule->isset('interval')) {
            var_dump($schedule->interval()->value);
            $result['interval'] = $schedule->interval()->value;
        }

        if ($schedule->isset('last')) {
            $result['last'] = $schedule->last();
        }

        if ($schedule->isset('lastAt')) {
            $result['last_at'] = $schedule->lastAt()->format('Y-m-d');
        }

        if ($schedule->isset('latest')) {
            $result['latest'] = $schedule->latest();
        }

        if ($schedule->isset('latestAt')) {
            $result['latest_at'] = $schedule->latestAt()->format('Y-m-d');
        }

        if ($schedule->isset('next')) {
            $result['next'] = $schedule->next();
        }

        if ($schedule->isset('nextAt')) {
            $result['next_at'] = $schedule->nextAt()->format('Y-m-d');
        }

        if ($schedule->isset('remaining')) {
            $result['remaining'] = $schedule->remaining();
        }

        if ($schedule->isset('terminationAt')) {
            $result['termination_at'] = $schedule->terminationAt()->format('Y-m-d');
        }

        return $result;
    }
}
