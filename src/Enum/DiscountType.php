<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Enum;

enum DiscountType: string
{
    case PROMOTION = 'promotion';
    case SALE      = 'sale';
    case TIER      = 'tier';
}
