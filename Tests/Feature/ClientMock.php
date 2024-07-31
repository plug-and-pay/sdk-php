<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;

class ClientMock implements ClientInterface
{
    protected array $responseBody;
    protected int $status;

    public function __construct(int $status = 200, array $body = [])
    {
        $this->status       = $status;
        $this->responseBody = $body;
    }

    public function get(string $path): Response
    {
        return $this->standardResponse();
    }

    public function patch(string $path, array $data): Response
    {
        return $this->standardResponse();
    }

    public function post(string $path, array $body): Response
    {
        return $this->standardResponse();
    }

    public function delete(string $path): Response
    {
        return $this->standardResponse();
    }

    private function standardResponse(): Response
    {
        $exception = ExceptionFactory::create($this->status, json_encode($this->responseBody, JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }

        return new Response($this->status, $this->responseBody);
    }
}
