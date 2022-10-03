<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class OrderPaymentShowMockClient extends ClientMock
{
    private string $path;
    private const BASIC_ORDER_PAYMENT = [
        'type'           => 'manual',
        'order_id'       => 11,
        'paid_at'        => '2022-09-30T08:34:44.000000Z',
        'status'         => 'paid',
        'url'            => 'https://plugandpay.nl/orders/payment-link/ec57a6b6-4fe2-45de-9aff-2183ec60ea20',
    ];

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct()
    {
        $this->responseBody = self::BASIC_ORDER_PAYMENT;
    }

    public function get(string $path): Response
    {
        $this->path = $path;
        return new Response(Response::HTTP_OK, ['data' => $this->responseBody]);
    }

    public function path(): string
    {
        return $this->path;
    }
}
