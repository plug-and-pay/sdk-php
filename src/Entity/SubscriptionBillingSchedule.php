<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use DateTimeImmutable;
use PlugAndPay\Sdk\Enum\Interval;

class SubscriptionBillingSchedule
{
    private Interval $interval;
    private ?int $last;
    private ?DateTimeImmutable $lastAt;
    private ?int $latest;
    private ?DateTimeImmutable $latestAt;
    private ?int $next;
    private ?DateTimeImmutable $nextAt;
    private int $remaining;
    private ?DateTimeImmutable $terminationAt;

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

    public function setLast(?int $last): self
    {
        $this->last = $last;
        return $this;
    }

    public function lastAt(): ?DateTimeImmutable
    {
        return $this->lastAt;
    }

    public function setLastAt(?DateTimeImmutable $lastAt): self
    {
        $this->lastAt = $lastAt;
        return $this;
    }

    public function latest(): ?int
    {
        return $this->latest;
    }

    public function setLatest(?int $latest): self
    {
        $this->latest = $latest;
        return $this;
    }

    public function latestAt(): ?DateTimeImmutable
    {
        return $this->latestAt;
    }

    public function setLatestAt(?DateTimeImmutable $latestAt): self
    {
        $this->latestAt = $latestAt;
        return $this;
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
