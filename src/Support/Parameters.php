<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Support;

class Parameters
{
    private const PARAMETER_SEPARATOR = '&';
    private const VALUE_SEPARATOR = ',';

    public static function toString(array $parameters): string
    {
        $parts = [];
        foreach ($parameters as $key => $values) {
            $values      = (array)$values;
            $parts[$key] = implode(self::VALUE_SEPARATOR, $values);
        }
        $query = http_build_query(array_filter($parts));
        return $query !== '' ? "?$query" : '';
    }
}
