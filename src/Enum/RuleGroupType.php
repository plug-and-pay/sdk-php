<?php

namespace PlugAndPay\Sdk\Enum;

enum RuleGroupType: string
{
    case PRODUCT      = 'product';
    case SUBSCRIPTION = 'subscription';
    case FORM         = 'form';
    case UPSELL       = 'upsell';
    case CHECKOUT     = 'checkout';
    case AFFILIATE    = 'affiliate';
}
