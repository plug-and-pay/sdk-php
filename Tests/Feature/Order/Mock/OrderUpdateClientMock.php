<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Support\Arr;

class OrderUpdateClientMock extends OrderShowClientMock
{
    protected array $requestBody;

    public function patch(string $path, array $body): Response
    {
        $this->responseBody = Arr::mergeDistinct($this->responseBody, $body);
        $this->path         = $path;
        $this->requestBody  = $body;
        return new Response(Response::HTTP_OK, $this->responseBody);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function requestBody(): array
    {
        return $this->requestBody;
    }
}
