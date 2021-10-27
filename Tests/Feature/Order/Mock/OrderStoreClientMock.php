<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Entity\Response;

class OrderStoreClientMock extends OrderShowClientMock implements ClientPostInterface
{
    protected array $requestBody;
    private string $path;

    public function path(): string
    {
        return $this->path;
    }

    public function post(string $path, array $body): Response
    {
        $this->path        = $path;
        $this->requestBody = $body;
        return new Response(Response::HTTP_OK, $this->response);
    }

    public function requestBody(): array
    {
        return $this->requestBody;
    }
}
