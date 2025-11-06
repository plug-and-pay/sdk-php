<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\SellerStatistics;
use PlugAndPay\Sdk\Entity\SellerStatisticsInternal;

class BodyToSellerStatistics implements BuildObjectInterface
{
    public static function build(array $data): SellerStatistics
    {
        return (new SellerStatisticsInternal())
            ->setClicks($data['clicks'] ?? null)
            ->setCommission($data['commission'] ?? 0)
            ->setLocked($data['locked'] ?? 0)
            ->setOrders($data['orders'] ?? 0)
            ->setPaidout($data['paidout'] ?? 0)
            ->setPending($data['pending'] ?? 0)
            ->setRecurring($data['recurring'] ?? 0)
            ->setSales($data['sales'] ?? 0)
            ->setValue($data['value'] ?? 0);
    }
}
