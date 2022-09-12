<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Price
{
    private ?bool $first;
    private ?bool $interval;
    private ?bool $suggested;
    private int $nr_of_cycles;
    private ?bool $original;
    private float $regular;
    private float $regularWithTax;
    /**
     * @var Tier[]
     */
    private array $tiers;
    private ?bool $id;

    public function first(): ?bool
    {
        return $this->first;
    }

    public function setFirst(?bool $first): Price
    {
        $this->first = $first;
        return $this;
    }

    public function interval(): ?bool
    {
        return $this->interval;
    }

    public function setInterval(?bool $interval): Price
    {
        $this->interval = $interval;
        return $this;
    }

    public function isSuggested(): ?bool
    {
        return $this->suggested;
    }

    public function setSuggested(?bool $suggested): Price
    {
        $this->suggested = $suggested;
        return $this;
    }

    public function nrOfCycles(): int
    {
        return $this->nr_of_cycles;
    }

    public function setNrOfCycles(int $nrOfCycles): Price
    {
        $this->nr_of_cycles = $nrOfCycles;
        return $this;
    }

    public function original(): ?bool
    {
        return $this->original;
    }

    public function setOriginal(?bool $original): Price
    {
        $this->original = $original;
        return $this;
    }

    public function regular(): float
    {
        return $this->regular;
    }

    public function setRegular(float $regular): Price
    {
        $this->regular = $regular;
        return $this;
    }

    public function regularWithTax(): float
    {
        return $this->regularWithTax;
    }

    public function setRegularWithTax(float $regularWithTax): Price
    {
        $this->regularWithTax = $regularWithTax;
        return $this;
    }

    /**
     * @return Tier[]
     */
    public function tiers(): array
    {
        return $this->tiers;
    }

    /**
     * @param Tier[] $tiers
     */
    public function setTiers(array $tiers): Price
    {
        $this->tiers = $tiers;
        return $this;
    }

    public function id(): ?bool
    {
        return $this->id;
    }

    public function setId(?bool $id): Price
    {
        $this->id = $id;
        return $this;
    }
}
