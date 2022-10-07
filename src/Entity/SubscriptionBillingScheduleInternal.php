<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;

/**
 * @internal
 */
class SubscriptionBillingScheduleInternal extends SubscriptionBillingSchedule
{
    /**
     * @internal
     */
    public function setLast(?int $last): self
    {
        $this->last = $last;
        return $this;
    }

    /**
     * @internal
     */
    public function setLastAt(?DateTimeImmutable $lastAt): self
    {
        $this->lastAt = $lastAt;
        return $this;
    }

    /**
     * @internal
     */
    public function setLatest(?int $latest): self
    {
        $this->latest = $latest;
        return $this;
    }

    /**
     * @internal
     */
    public function setLatestAt(?DateTimeImmutable $latestAt): self
    {
        $this->latestAt = $latestAt;
        return $this;
    }
}
