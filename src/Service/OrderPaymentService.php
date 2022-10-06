<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use Exception;
use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrderPayment;
use PlugAndPay\Sdk\Director\ToBody\OrderPaymentToBody;
use PlugAndPay\Sdk\Entity\Payment;

class OrderPaymentService
{
    private ClientPatchInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws Exception
     */
    public function find(int $orderId): Payment
    {
        $response = $this->client->get("/v2/orders/$orderId/payment");
        return BodyToOrderPayment::build($response->body()['data']);
    }

    /**
     * @throws Exception
     */
    public function update(int $orderId, callable $update): Payment
    {
        $payment  = new Payment();
        $update($payment);
        $body     = OrderPaymentToBody::build($payment);
        $response = $this->client->patch("/v2/orders/$orderId/payment", $body);

        return BodyToOrderPayment::build($response->body()['data']);
    }
}
