<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\Interval;
use PlugAndPay\Sdk\Traits\HasDynamicFields;

class Price
{
    use HasDynamicFields;

    protected int $id;
    protected ?PriceFirst $first;
    protected ?Interval $interval;
    protected ?bool $suggested;
    protected int $nr_of_cycles;
    protected ?PriceOriginal $original;
    protected PriceRegular $regular;
    /** @var PriceTier[] */
    protected array $tiers;

    public function id(): int
    {
        return $this->id;
    }

    public function first(): ?PriceFirst
    {
        return $this->first;
    }

    public function setFirst(?PriceFirst $first): self
    {
        $this->first = $first;

        return $this;
    }

    public function interval(): ?Interval
    {
        return $this->interval;
    }

    public function setInterval(?Interval $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function isSuggested(): ?bool
    {
        return $this->suggested;
    }

    public function setSuggested(?bool $suggested): self
    {
        $this->suggested = $suggested;

        return $this;
    }

    public function nrOfCycles(): int
    {
        return $this->nr_of_cycles;
    }

    public function setNrOfCycles(int $nrOfCycles): self
    {
        $this->nr_of_cycles = $nrOfCycles;

        return $this;
    }

    public function original(): ?PriceOriginal
    {
        return $this->original;
    }

    public function setOriginal(?PriceOriginal $original): self
    {
        $this->original = $original;

        return $this;
    }

    public function regular(): PriceRegular
    {
        return $this->regular;
    }

    public function setRegular(PriceRegular $regular): self
    {
        $this->regular = $regular;

        return $this;
    }

    public function tiers(): array
    {
        return $this->tiers;
    }

    public function setTiers(array $tiers): self
    {
        $this->tiers = $tiers;

        return $this;
    }
}
