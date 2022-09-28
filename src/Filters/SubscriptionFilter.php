<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

use DateTimeInterface;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\Interval;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;
use PlugAndPay\Sdk\Enum\Type;

class SubscriptionFilter
{
    private array $parameters = [];

    public function affiliateId(int $value): self
    {
        $this->parameters['affiliate_id'] = $value;
        return $this;
    }

    public function billingScheduleInterval(Interval $interval): self
    {
        $this->parameters['billing_schedule_interval'] = $interval->value;
        return $this;
    }

    public function billingScheduleLatestAt(DateTimeInterface $value): self
    {
        $this->parameters['billing_schedule_latest_at'] = $value->format('Y-m-d');
        return $this;
    }

    public function billingScheduleNextAt(DateTimeInterface $value): self
    {
        $this->parameters['billing_schedule_next_at'] = $value->format('Y-m-d');
        return $this;
    }

    public function country(CountryCode $country): self
    {
        $this->parameters['country'] = $country->value;
        return $this;
    }

    public function hasOrders(bool $value): self
    {
        $this->parameters['has_orders'] = $value;
        return $this;
    }

    public function isTrial(bool $value): self
    {
        $this->parameters['is_trial'] = $value;
        return $this;
    }

    public function limit(int $value): self
    {
        $this->parameters['limit'] = $value;
        return $this;
    }

    public function mode(Mode $mode): self
    {
        $this->parameters['mode'] = $mode->value;
        return $this;
    }

    public function page(int $value): self
    {
        $this->parameters['page'] = $value;
        return $this;
    }

    public function productId(int $value): self
    {
        $this->parameters['product_id'] = $value;
        return $this;
    }

    public function isFirst(bool $value): self
    {
        $this->parameters['is_first'] = $value;
        return $this;
    }

    public function query(string $value): self
    {
        $this->parameters['q'] = $value;
        return $this;
    }

    public function sinceCreatedAt(DateTimeInterface $value): self
    {
        $this->parameters['since_created_at'] = $value->format('Y-m-d');
        return $this;
    }

    public function status(SubscriptionStatus $status): self
    {
        $this->parameters['status'] = $status->value;
        return $this;
    }

    public function tag(array $value): self
    {
        $this->parameters['tag'] = implode(',', $value);
        return $this;
    }

    public function type(Type $type): self
    {
        $this->parameters['type'] = $type->value;
        return $this;
    }

    public function untilCreatedAt(DateTimeInterface $value): self
    {
        $this->parameters['until_created_at'] = $value->format('Y-m-d');
        return $this;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }
}
