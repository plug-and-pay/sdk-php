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
        return new SellerStatisticsInternal();
    }
}