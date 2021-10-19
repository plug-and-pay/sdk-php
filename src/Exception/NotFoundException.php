<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

class NotFoundException extends ClientException
{
    public function __construct(string $entity, int $id)
    {
        parent::__construct("$entity not found with id $id");
    }
}
