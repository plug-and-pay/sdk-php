<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

use DateTimeInterface;

class OrderFilter
{
    private array $parameters = [];

    public function affiliateId(int $value): self
    {
        $this->parameters['affiliate_id'] = $value;
        return $this;
    }

    public function checkoutId(int $value): self
    {
        $this->parameters['checkout_id'] = $value;
        return $this;
    }

    public function contractId(int...$value): self
    {
        $this->parameters['contract_id'] = $value;
        return $this;
    }

    public function contractType(string...$value): self
    {
        $this->parameters['contract_type'] = $value;
        return $this;
    }

    public function country(string $value): self
    {
        $this->parameters['country'] = $value;
        return $this;
    }

    public function direction(string $value): self
    {
        $this->parameters['direction'] = $value;
        return $this;
    }

    public function discountCode(string $value): self
    {
        $this->parameters['discount_code'] = $value;
        return $this;
    }

    public function email(string $value): self
    {
        $this->parameters['email'] = $value;
        return $this;
    }

    public function hasBump(bool $value): self
    {
        $this->parameters['has_bump'] = $value;
        return $this;
    }

    public function hasTax(bool $value): self
    {
        $this->parameters['has_tax'] = $value;
        return $this;
    }

    public function invoiceStatus(string $value): self
    {
        $this->parameters['invoice_status'] = $value;
        return $this;
    }

    public function isDeleted(bool $value): self
    {
        $this->parameters['is_deleted'] = $value;
        return $this;
    }

    public function isFirst(bool $value): self
    {
        $this->parameters['is_first'] = $value;
        return $this;
    }

    public function isHidden(bool $value): self
    {
        $this->parameters['is_hidden'] = $value;
        return $this;
    }

    public function isUpsell(bool $value): self
    {
        $this->parameters['is_upsell'] = $value;
        return $this;
    }

    public function limit(int $value): self
    {
        $this->parameters['limit'] = $value;
        return $this;
    }

    public function mode(string $value): self
    {
        $this->parameters['mode'] = $value;
        return $this;
    }

    public function page(int $value): self
    {
        $this->parameters['page'] = $value;
        return $this;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function paymentStatus(string...$value): self
    {
        $this->parameters['payment_status'] = $value;
        return $this;
    }

    public function productId(int $value): self
    {
        $this->parameters['product_id'] = $value;
        return $this;
    }

    public function productTag(string $value): self
    {
        $this->parameters['product_tag'] = $value;
        return $this;
    }

    public function query(string $value): self
    {
        $this->parameters['q'] = $value;
        return $this;
    }

    public function sinceInvoiceDate(DateTimeInterface $value): self
    {
        $this->parameters['since_invoice_date'] = $value;
        return $this;
    }

    public function sincePaidAt(DateTimeInterface $value): self
    {
        $this->parameters['since_paid_at'] = $value;
        return $this;
    }

    public function sort(string $value): self
    {
        $this->parameters['sort'] = $value;
        return $this;
    }

    public function source(string $value): self
    {
        $this->parameters['source'] = $value;
        return $this;
    }

    public function untilInvoiceDate(DateTimeInterface $value): self
    {
        $this->parameters['until_invoice_date'] = $value;
        return $this;
    }

    public function untilPaidAt(DateTimeInterface $value): self
    {
        $this->parameters['until_paid_at'] = $value;
        return $this;
    }
}
