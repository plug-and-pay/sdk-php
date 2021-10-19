<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Entity\Response;

class OrderGetClientMock implements ClientGetInterface
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data + [
                'created_at'     => '2019-01-16T00:00:00.000000Z',
                'deleted_at'     => '2019-01-16T00:00:00.000000Z',
                'id'             => 1,
                'invoice_number' => '20214019-T',
                'invoice_status' => 'concept',
                'is_first'       => true,
                'is_hidden'      => false,
                'mode'           => 'live',
                'reference'      => '0b13e52d-b058-32fb-8507-10dec634a07c',
                'source'         => 'api',
                'subtotal'       =>
                    [
                        'currency' => 'EUR',
                        'value'    => '75.00',
                    ],
                'total'          =>
                    [
                        'currency' => 'EUR',
                        'value'    => '75.00',
                    ],
                'updated_at'     => '2019-01-16T00:00:00.000000Z',
            ];
    }

    public function get(string $path): Response
    {
        return new Response(Response::HTTP_OK, $this->data);
    }
}
