<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use Exception;

class RelationNotLoadedException extends Exception
{
    public function __construct(string $relation)
    {
        parent::__construct("Can not load relation $relation. You can use ->include([...]) to fetch te relation.");
    }
}
