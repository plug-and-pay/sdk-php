<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

interface ClientDeleteInterface
{
    public function delete(string $path);
}
