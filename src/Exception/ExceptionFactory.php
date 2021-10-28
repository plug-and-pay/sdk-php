<?php /** @noinspection MultipleReturnStatementsInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use Exception;
use PlugAndPay\Sdk\Entity\Response;

class ExceptionFactory
{
    public static function createByResponse(Response $response): ?Exception
    {
        switch ($response->status()) {
            case Response::HTTP_UNPROCESSABLE_ENTITY:
                return new ValidationException($response->body()['errors']);
            case Response::HTTP_NOT_FOUND:
                return new NotFoundException();
            default:
                return null;
        }
    }
}
