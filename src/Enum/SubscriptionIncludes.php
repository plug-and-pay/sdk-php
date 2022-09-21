<?php

namespace PlugAndPay\Sdk\Enum;

enum SubscriptionIncludes: string
{
    case BILLING = 'billing';
    case META = 'meta';
    case PRICING = 'pricing';
    case PRODUCT = 'product';
    case TAGS = 'tags';
    case TRIAL = 'trial';
}
