<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Entity\Response;

class OrderStoreClientMock extends OrderShowClientMock implements ClientPostInterface
{
    protected array $requestBody;

    public function post(string $path, array $body): Response
    {
        $this->requestBody = $body;
        return new Response(Response::HTTP_CREATED, $this->response);
    }

    public function requestBody(): array
    {
        return $this->requestBody;
    }
}
