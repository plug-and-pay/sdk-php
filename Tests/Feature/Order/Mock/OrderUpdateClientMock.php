<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Entity\Response;

class OrderUpdateClientMock extends OrderShowClientMock implements ClientPatchInterface
{
    protected array $requestBody;
    private string $path;

    public function patch(string $path, array $body): Response
    {
        $this->response    = $body + $this->response;
        $this->path        = $path;
        $this->requestBody = $body;
        return new Response(Response::HTTP_OK, $this->response);
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
