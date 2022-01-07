<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;

class Rate
{
    private string $country;
    private int $id;
    private float $percentage;

    public function __construct(?float $percentage, ?string $country, int $id = null)
    {
        if ($percentage !== null) {
            $this->percentage = $percentage;
        }
        if ($country !== null) {
            $this->country = $country;
        }
        if ($id !== null) {
            $this->id = $id;
        }
    }

    public static function byId(int $id)
    {
        return new self(null, null, $id);
    }

    public function country(): string
    {
        return $this->country;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Method '$field' does not exists");
        }
        return isset($this->{$field});
    }

    public function percentage(): float
    {
        return $this->percentage;
    }
}
