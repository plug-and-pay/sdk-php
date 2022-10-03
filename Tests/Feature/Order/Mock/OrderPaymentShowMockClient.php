<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class OrderPaymentShowMockClient extends ClientMock
{
    private string $path;
    private const BASIC_ORDER_PAYMENT = [
        'customer_id'    => null,
        'mandate_id'     => null,
        'method'         => null,
        'order_id'       => 11,
        'paid_at'        => null,
        'provider'       => null,
        'status'         => 'paid',
        'transaction_id' => null,
        'type'           => 'manual',
        'url'            => 'https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c',
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
