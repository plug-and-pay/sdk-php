<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\HasDynamicFields;

class SellerStatistics extends AbstractEntity
{
    use HasDynamicFields;

    // Based on API spec, statistics can be null, so we'll use dynamic fields for now
}
