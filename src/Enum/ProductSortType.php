<?php

namespace PlugAndPay\Sdk\Enum;

enum ProductSortType: string
{
    case ACTIVE_SUBSCRIPTIONS = 'active_subscriptions';
    case ID = 'id';
    case TITLE = 'title';
    case TOTAL_ORDERS = 'total_orders';
    case TOTAL_REVENUE = 'total_revenue';
}
