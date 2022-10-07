<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\Interval;

class SubscriptionBillingSchedule
{
    protected Interval $interval;
    protected ?int $last;
    protected ?DateTimeImmutable $lastAt;
    protected ?int $latest;
    protected ?DateTimeImmutable $latestAt;
    protected ?int $next;
    protected ?DateTimeImmutable $nextAt;
    protected int $remaining;
    protected ?DateTimeImmutable $terminationAt;

    public function interval(): Interval
    {
        return $this->interval;
    }

    public function setInterval(Interval $interval): self
    {
        $this->interval = $interval;
        return $this;
    }

    public function last(): ?int
    {
        return $this->last;
    }

    public function lastAt(): ?DateTimeImmutable
    {
        return $this->lastAt;
    }

    public function latest(): ?int
    {
        return $this->latest;
    }

    public function latestAt(): ?DateTimeImmutable
    {
        return $this->latestAt;
    }

    public function next(): ?int
    {
        return $this->next;
    }

    public function setNext(?int $next): self
    {
        $this->next = $next;
        return $this;
    }

    public function nextAt(): ?DateTimeImmutable
    {
        return $this->nextAt;
    }

    public function setNextAt(?DateTimeImmutable $nextAt): self
    {
        $this->nextAt = $nextAt;
        return $this;
    }

    public function remaining(): int
    {
        return $this->remaining;
    }

    public function setRemaining(int $remaining): self
    {
        $this->remaining = $remaining;
        return $this;
    }

    public function terminationAt(): ?DateTimeImmutable
    {
        return $this->terminationAt;
    }

    public function setTerminationAt(?DateTimeImmutable $terminationAt): self
    {
        $this->terminationAt = $terminationAt;
        return $this;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
