<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

/**
 * @internal
 */
class PayoutMethodInternal extends PayoutMethod
{
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function setSettings(?array $settings): self
    {
        $this->settings = $settings;

        return $this;
    }
}
