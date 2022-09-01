<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;

class Tax
{
    private float $amount;
    private Rate $rate;

    public function amount(): float
    {
        return $this->amount;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Method '$field' does not exists");
        }
        return isset($this->{$field});
    }

    public function rate(): Rate
    {
        return $this->rate;
    }

    public function setAmount(float $amount): Tax
    {
        $this->amount = $amount;
        return $this;
    }

    public function setRate(Rate $rate): Tax
    {
        $this->rate = $rate;
        return $this;
    }
}
