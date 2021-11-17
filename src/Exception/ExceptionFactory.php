<?php /** @noinspection MultipleReturnStatementsInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use Exception;
use PlugAndPay\Sdk\Entity\Response;

class ExceptionFactory
{
    /**
     * @return \PlugAndPay\Sdk\Exception\ValidationException|\PlugAndPay\Sdk\Exception\NotFoundException
     * @throws \JsonException
     */
    public static function create(int $status, string $body = ''): ?Exception
    {
        switch ($status) {
            case Response::HTTP_UNPROCESSABLE_ENTITY:
                $body = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
                return new ValidationException($body['errors']);
            case Response::HTTP_NOT_FOUND:
                return new NotFoundException();
            default:
                return null;
        }
    }
}
