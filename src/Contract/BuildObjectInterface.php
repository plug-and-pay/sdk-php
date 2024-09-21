<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

use PlugAndPay\Sdk\Entity\AbstractEntity;

interface BuildObjectInterface
{
    public static function build(array $data): array | AbstractEntity;
}
