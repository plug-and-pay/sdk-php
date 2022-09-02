<?php

namespace PlugAndPay\Sdk\Enum;

enum OrderIncludes: string
{
    case BILLING = 'billing';
    case COMMENTS = 'comments';
    case DISCOUNTS = 'discounts';
    case ITEMS = 'items';
    case PAYMENT = 'payment';
    case TAGS = 'tags';
    case TAXES = 'taxes';
}
