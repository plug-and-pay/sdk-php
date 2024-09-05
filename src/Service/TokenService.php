<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Exception\InvalidTokenException;

class TokenService
{
    private const ERROR_INVALID_STRUCTURE = 'Invalid JWT structure.';
    private const ERROR_INVALID_JSON = 'Invalid payload JSON.';
    private const ERROR_NO_EXPIRATION = 'Expiration time not set in token.';
    private const MIN_TTL_SECONDS = 30;

    /**
     * @throws InvalidTokenException
     */
    public static function isValid(string $jwt): bool
    {
        $parts = explode('.', $jwt);

        if (count($parts) !== 3) {
            throw new InvalidTokenException(self::ERROR_INVALID_STRUCTURE);
        }

        $decodedPayload = self::base64UrlDecode($parts[1]);
        $payloadArray   = json_decode($decodedPayload, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidTokenException(self::ERROR_INVALID_JSON);
        }

        if (!isset($payloadArray['exp'])) {
            throw new InvalidTokenException(self::ERROR_NO_EXPIRATION);
        }

        $currentTime = time();
        $expirationTime = $payloadArray['exp'];

        // Check if the token is expired or has less than 30 seconds to live
        return !($currentTime >= $expirationTime || ($expirationTime - $currentTime) < self::MIN_TTL_SECONDS);
    }

    private static function base64UrlDecode(string $input): string
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $input .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
