<?php

namespace PlugAndPay\Sdk\Enum;

enum Interval: string
{
    case MONTHLY   = 'monthly';
    case QUARTERLY = 'quarterly';
    case YEARLY    = 'yearly';
}
