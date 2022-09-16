<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\TaxProfile;

class TaxProfileToBody
{
    public static function build(TaxProfile $profile): array
    {
        $result = [];

        if ($profile->isset('id')) {
            $result['id'] = $profile->id();
        }

        return $result;
    }
}
