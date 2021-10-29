<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Contract\ClientDeleteInterface;
use PlugAndPay\Sdk\Entity\Response;

class OrderDestroyClientMock implements ClientDeleteInterface
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
