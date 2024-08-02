<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Support;

class Parameters
{
    public static function toString(array $parameters): string
    {
        $parts = [];
        foreach ($parameters as $key => $values) {
            if (is_array($values)) {
                if (array_key_exists(0, $values)) {
                    $parts[$key] = self::convertValue($values[0]);
                } else {
                    foreach ($values as $nestedKey => $nestedValue) {
                        $parts["{$key}[{$nestedKey}]"] = self::convertValue($nestedValue);
                    }
                }
                continue;
            }

            $parts[$key] = self::convertValue($values);
        }
        $query = self::buildQuery(array_filter($parts));

        return $query !== '' ? "?$query" : '';
    }

    private static function convertValue($value): string
    {
        if (is_array($value)) {
            return implode(',', array_map([self::class, 'convertValue'], $value));
        }

        if ($value instanceof \UnitEnum) {
            return $value->value;
        }

        return (string) $value;
    }

    private static function buildQuery(array $params, string $prefix = ''): string
    {
        $query = [];
        foreach ($params as $key => $value) {
            $encodedKey = $prefix ? "{$prefix}[{$key}]" : $key;
            if (is_array($value)) {
                $query[] = self::buildQuery($value, $encodedKey);
            } else {
                $query[] = $encodedKey . '=' . urlencode($value);
            }
        }

        return implode('&', $query);
    }
}
