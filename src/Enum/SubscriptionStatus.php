<?php

namespace PlugAndPay\Sdk\Enum;

enum SubscriptionStatus: string
{
    case ACTIVE    = 'active';
    case CANCELLED = 'cancelled';
    case ENDED     = 'ended';
    case INACTIVE  = 'inactive';
}
