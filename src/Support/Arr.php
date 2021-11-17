<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Support;

use function is_array;

class Arr
{
    public static function mergeDistinct(array $array1, array $array2): array
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = self::mergeDistinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }
}
