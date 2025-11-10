<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\AffiliateSeller\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class AffiliateSellerIndexMockClient extends ClientMock
{
    private string $path;

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $data = [[]])
    {
        foreach ($data as $sellerData) {
            $this->responseBody[] = $sellerData + AffiliateSellerShowMockClient::BASIC_SELLER;
        }
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
