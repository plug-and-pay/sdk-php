<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Traits;

use BadFunctionCallException;

trait ValidatesFieldMethods
{
    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
