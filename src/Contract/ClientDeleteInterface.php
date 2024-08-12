<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

use PlugAndPay\Sdk\Entity\Response;

interface ClientDeleteInterface
{
    public function delete(string $path): Response;
}
