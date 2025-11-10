<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Enum;

enum SellerSortType: string
{
    case COMMISSION      = 'commission';
    case LOCKED_REVENUE  = 'locked_revenue';
    case NAME            = 'name';
    case PAID_REVENUE    = 'paid_revenue';
    case PENDING_REVENUE = 'pending_revenue';
    case SALES           = 'sales';
    case TOTAL_REVENUE   = 'total_revenue';
}
