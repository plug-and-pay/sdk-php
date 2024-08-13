<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

use PlugAndPay\Sdk\Entity\AbstractEntity;

interface BuildToInterface
{
    public function build(array $data): AbstractEntity;
}
