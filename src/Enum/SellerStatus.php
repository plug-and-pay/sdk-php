<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Enum;

enum SellerStatus: string
{
    case ACCEPTED = 'accepted';
    case PENDING  = 'pending';
    case DECLINED = 'declined';
}