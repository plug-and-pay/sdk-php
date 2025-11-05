<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\HasDynamicFields;

class SellerPayoutOptions extends AbstractEntity
{
    use HasDynamicFields;

    // Based on API spec, payout_options can be null, so we'll use dynamic fields for now
}
