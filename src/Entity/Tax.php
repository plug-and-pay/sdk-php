<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Tax
{
    private Money $amount;
    private Rate $rate;

    public function amount(): Money
    {
        return $this->amount;
    }

    public function rate(): Rate
    {
        return $this->rate;
    }

    public function setAmount(Money $amount): Tax
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
