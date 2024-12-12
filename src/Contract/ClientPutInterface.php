<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

use PlugAndPay\Sdk\Entity\Response;

interface ClientPutInterface
{
    public function put(string $path, array $data): Response;
}
