<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Enum;

enum SellerSortType: string
{
    case NAME       = 'name';
    case ORDERS     = 'orders';
    case SALES      = 'sales';
    case PENDING    = 'pending';
    case LOCKED     = 'locked';
    case PAIDOUT    = 'paidout';
    case VALUE      = 'value';
    case CREATED_AT = 'created_at';
}
