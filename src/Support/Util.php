<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Support;

use DateTime;

class Util
{
    public static function validateDate(string $date, string $format = 'Y-m-d H:i:s'): bool
    {
        $dateFormat = DateTime::createFromFormat($format, $date);

        return $dateFormat && $dateFormat->format($format) == $date;
    }
}
