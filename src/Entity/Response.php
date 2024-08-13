<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Response extends AbstractEntity
{
    public const HTTP_OK                   = 200;
    public const HTTP_CREATED              = 201;
    public const HTTP_NO_CONTENT           = 204;
    public const HTTP_UNAUTHORIZED         = 401;
    public const HTTP_NOT_FOUND            = 404;
    public const HTTP_UNPROCESSABLE_ENTITY = 422;

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
