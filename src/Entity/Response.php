<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Response
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_NOT_FOUND = 404;

    private array $body;
    private array $headers;
    private int $status;

    public function __construct(int $status, array $body = [], array $headers = [])
    {
        $this->status  = $status;
        $this->body    = $body;
        $this->headers = $headers;
    }

    public function body(): array
    {
        return $this->body;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function status(): int
    {
        return $this->status;
    }
}
