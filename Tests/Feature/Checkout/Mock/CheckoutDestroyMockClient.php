<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Checkout\Mock;

use JsonException;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class CheckoutDestroyMockClient extends ClientMock
{
    private string $path;

    /**
     * @throws NotFoundException
     * @throws ValidationException
     * @throws JsonException
     */
    public function delete(string $path): Response
    {
        $this->path = $path;
        $exception  = ExceptionFactory::create($this->status);
        if ($exception) {
            throw $exception;
        }

        return new Response(Response::HTTP_NO_CONTENT);
    }

    public function path(): string
    {
        return $this->path;
    }
}
