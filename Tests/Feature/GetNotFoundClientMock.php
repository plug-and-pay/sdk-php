<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Entity\Response;

class GetNotFoundClientMock implements ClientGetInterface
{
    public function get(string $path): Response
    {
        return new Response(Response::HTTP_NOT_FOUND);
    }
}
