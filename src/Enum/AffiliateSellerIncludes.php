<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Enum;

enum AffiliateSellerIncludes: string
{
    case ADDRESS        = 'address';
    case CONTACT        = 'contact';
    case PROFILE        = 'profile';
    case STATISTICS     = 'statistics';
    case PAYOUT_OPTIONS = 'payout_options';
    case PAYOUT_METHODS = 'payout_methods';
}
