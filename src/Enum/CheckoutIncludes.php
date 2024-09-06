<?php

namespace PlugAndPay\Sdk\Enum;

enum CheckoutIncludes: string
{
    case PRODUCT = 'product';
    case PRODUCT_PRICING = 'product_pricing';
}
