<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

use PlugAndPay\Sdk\Entity\Response;

interface ClientPatchInterface
{
    public function patch(string $path, array $body): Response;
}
