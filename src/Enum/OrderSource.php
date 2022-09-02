<?php

namespace PlugAndPay\Sdk\Enum;

enum OrderSource: string
{
    case ADMIN = 'admin';
    case API = 'api';
    case CHECKOUT = 'checkout';
    case IMPORT = 'import';
    case RECURRING = 'recurring';
    case UPGRADE = 'upgrade';
    case UPSELL = 'upsell';
    case UNKNOWN = 'unknown';
}
