<?php

namespace PlugAndPay\Sdk\Enum;

enum CheckoutSort: string
{
    case PRODUCT    = 'product';
    case CONVERSION = 'conversion';
    case VIEWS      = 'views';
}
