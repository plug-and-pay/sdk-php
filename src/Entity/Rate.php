<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Rate
{
    private string $country;
    private int $id;
    private float $percentage;

    public function __construct(?float $percentage, ?string $country, int $id = null)
    {
        if ($id === null) {
            $this->country    = $country;
            $this->percentage = $percentage;
        } else {
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
        return isset($this->{$field});
    }

    public function percentage(): float
    {
        return $this->percentage;
    }
}
