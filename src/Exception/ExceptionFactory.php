<?php

/** @noinspection MultipleReturnStatementsInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use Exception;
use JsonException;
use PlugAndPay\Sdk\Entity\Response;

class ExceptionFactory
{
    /**
     * @return ValidationException|NotFoundException
     * @throws JsonException
     */
    public static function create(int $status, string $body = ''): ?Exception
    {
        switch ($status) {
            case Response::HTTP_UNPROCESSABLE_ENTITY:
                $body = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

                return new ValidationException($body['errors']);
            case Response::HTTP_NOT_FOUND:
                return new NotFoundException();
            case Response::HTTP_UNAUTHORIZED:
                return new UnauthenticatedException();
            case Response::HTTP_BAD_REQUEST:
                $body = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

                return new \RuntimeException("Error: $status; Body: " . $body['message']);
            default:
                if ($status < 400) {
                    return null;
                }

                return new \RuntimeException("Error: $status; Known body: $body");
        }
    }
}
