<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

class RelationNotLoadedException extends ClientException
{
    public function __construct(string $relation)
    {
        parent::__construct("Can not load relation $relation. You can use ->with(['$relation']) to first fetch te relation.");
    }
}
