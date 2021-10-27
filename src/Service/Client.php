<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Entity\Response;

class Client implements ClientPatchInterface, ClientPostInterface, ClientGetInterface
{
    public function get(string $path): Response
    {
        // TODO: Implement get() method.
    }

    public function patch(string $path, array $body): Response
    {
        // TODO: Implement patch() method.
    }

    public function post(string $path, array $body): Response
    {
        // TODO: Implement post() method.
    }
}
