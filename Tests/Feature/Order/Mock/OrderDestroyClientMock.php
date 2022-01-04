<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class OrderDestroyClientMock extends ClientMock
{
    private string $path;

    public function delete(string $path): Response
    {
        $this->path = $path;

        return new Response(Response::HTTP_NO_CONTENT);
    }

    public function path(): string
    {
        return $this->path;
    }
}
