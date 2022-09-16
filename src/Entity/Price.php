<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\Interval;

class Price
{
    private ?PriceFirst $first;
    private ?Interval $interval;
    private ?bool $suggested;
    private int $nr_of_cycles;
    private ?PriceOriginal $original;
    private PriceRegular $regular;
    /**
     * @var Tier[]
     */
    private array $tiers;
    private int $id;

    public function first(): ?PriceFirst
    {
        return $this->first;
    }

    public function setFirst(?PriceFirst $first): Price
    {
        $this->first = $first;
        return $this;
    }

    public function interval(): ?Interval
    {
        return $this->interval;
    }

    public function setInterval(?Interval $interval): Price
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

    public function original(): ?PriceOriginal
    {
        return $this->original;
    }

    public function setOriginal(?PriceOriginal $original): Price
    {
        $this->original = $original;
        return $this;
    }

    public function regular(): PriceRegular
    {
        return $this->regular;
    }

    public function setRegular(PriceRegular $regular): Price
    {
        $this->regular = $regular;
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

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): Price
    {
        $this->id = $id;
        return $this;
    }
}
