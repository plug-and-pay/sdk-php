<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Support;

use UnitEnum;

class Parameters
{
    private const VALUE_SEPARATOR = ',';

    public static function toString(array $parameters): string
    {
        $parts = [];
        foreach ($parameters as $key => $values) {
            $values = array_map(function ($value) {
                if ($value instanceof UnitEnum) {
                    $value = $value->value;
                }

                if (is_string($value) && !DateUtils::validateDate($value)) {
                    $value = str_replace(' ', '-', $value);
                }

                return $value;
            }, (array) $values);
            $parts[$key] = implode(self::VALUE_SEPARATOR, $values);
        }
        $query = http_build_query(array_filter($parts));

        return $query !== '' ? "?$query" : '';
    }
}
