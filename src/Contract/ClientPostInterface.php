<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

use PlugAndPay\Sdk\Entity\Response;

interface ClientPostInterface
{
    public function post(string $path, array $body): Response;
}
