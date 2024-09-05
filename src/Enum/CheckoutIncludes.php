<?php

namespace PlugAndPay\Sdk\Enum;

enum CheckoutIncludes: string
{
    case CONFIRMATION = 'confirmation';
    case CUSTOM_FIELDS = 'custom_fields';
    case ORDER_BUMPS = 'order_bumps';
    case POPUPS = 'popups';
    case PRODUCT = 'product';
    case PRODUCT_PRICING = 'product_pricing';
    case SETTINGS = 'settings';
    case STATISTICS = 'statistics';
    case TEMPLATE = 'template';
    case UPSELLS = 'upsells';
    case WEBHOOKS = 'webhooks';
}
