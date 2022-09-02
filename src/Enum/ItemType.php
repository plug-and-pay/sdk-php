<?php

namespace PlugAndPay\Sdk\Enum;

enum ItemType: string
{
    case GIFT = 'gift';
    case ONE_CLICK_UPSELL = 'one-click-upsell';
    case ORDER_BUMP = 'order-bump';
    case STANDARD = 'standard';
}
