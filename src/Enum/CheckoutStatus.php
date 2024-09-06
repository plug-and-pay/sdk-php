<?php

namespace PlugAndPay\Sdk\Enum;

enum CheckoutStatus: string
{
    case DELETED  = 'deleted';
    case INACTIVE = 'inactive';
    case ACTIVE   = 'active';
    case EXPIRED  = 'expired';
    case ALL      = 'all';
}
