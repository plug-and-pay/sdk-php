<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

use DateTimeInterface;
use PlugAndPay\Sdk\Enum\Direction;
use PlugAndPay\Sdk\Enum\SellerSortType;
use PlugAndPay\Sdk\Enum\SellerStatus;

class AffiliateSellerFilter
{
    private array $parameters = [];

    public function direction(Direction $direction): self
    {
        $this->parameters['direction'] = $direction->value;

        return $this;
    }

    public function eligibleForPayout(bool $value): self
    {
        $this->parameters['eligible_for_payout'] = $value;

        return $this;
    }

    public function limit(int $value): self
    {
        $this->parameters['limit'] = $value;

        return $this;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function query(string $value): self
    {
        $this->parameters['q'] = $value;

        return $this;
    }

    public function since(DateTimeInterface $value): self
    {
        $this->parameters['since'] = $value->format('Y-m-d');

        return $this;
    }

    public function sort(SellerSortType $value): self
    {
        $this->parameters['sort'] = $value->value;

        return $this;
    }

    public function status(SellerStatus ...$status): self
    {
        $this->parameters['status'] = $status;

        return $this;
    }

    public function until(DateTimeInterface $value): self
    {
        $this->parameters['until'] = $value->format('Y-m-d');

        return $this;
    }
}
