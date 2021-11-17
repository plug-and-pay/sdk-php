<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;

class ClientMock implements ClientPatchInterface, ClientPostInterface, ClientGetInterface
{
    private array $responseBody;
    private int $status;

    public function __construct(int $status, array $body = [])
    {
        $this->status       = $status;
        $this->responseBody = $body;
    }

    public function get(string $path): Response
    {
        $exception = ExceptionFactory::create($this->status, json_encode($this->responseBody, JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }
        return new Response($this->status, $this->responseBody);
    }

    public function patch(string $path, array $body): Response
    {
        $exception = ExceptionFactory::create($this->status, json_encode($this->responseBody, JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }
        return new Response($this->status, $this->responseBody);
    }

    public function post(string $path, array $body): Response
    {
        $exception = ExceptionFactory::create($this->status, json_encode($this->responseBody, JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }
        return new Response($this->status, $this->responseBody);
    }
}
