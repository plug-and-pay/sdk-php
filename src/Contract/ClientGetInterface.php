<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

use PlugAndPay\Sdk\Entity\Response;

interface ClientGetInterface
{
    public function get(string $path): Response;
}
