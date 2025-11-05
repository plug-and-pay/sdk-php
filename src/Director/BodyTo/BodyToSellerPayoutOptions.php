<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\SellerPayoutOptions;
use PlugAndPay\Sdk\Entity\SellerPayoutOptionsInternal;

class BodyToSellerPayoutOptions implements BuildObjectInterface
{
    public static function build(array $data): SellerPayoutOptions
    {
        return new SellerPayoutOptionsInternal();
    }
}
