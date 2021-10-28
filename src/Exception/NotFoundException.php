<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $entity = null, int $id = null)
    {
        if ($entity) {
            $message = "$entity not found with id $id";
        } else {
            $message = 'Not found';
        }

        parent::__construct($message);
    }
}
