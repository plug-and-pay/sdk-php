<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Entity\Response;

class OrdersIndexClientMock implements ClientGetInterface
{
    private array $data;

    public function __construct(array $data = [[]])
    {
        foreach ($data as $orderData) {
            $this->data[] = $orderData + OrderShowClientMock::RESPONSE_BASIC;
        }
    }

    public function get(string $path): Response
    {
        return new Response(Response::HTTP_OK, $this->data);
    }
}
