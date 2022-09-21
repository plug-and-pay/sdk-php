<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

use DateTimeInterface;
use PlugAndPay\Sdk\Enum\ContractType;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\Direction;
use PlugAndPay\Sdk\Enum\InvoiceStatus;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\OrderSortType;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\PaymentStatus;

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

    public function contractType(ContractType... $contractType): self
    {
        $this->parameters['contract_type'] = $contractType;
        return $this;
    }

    public function country(CountryCode $value): self
    {
        $this->parameters['country'] = $value->value;
        return $this;
    }

    public function direction(Direction $direction): self
    {
        $this->parameters['direction'] = $direction->value;
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

    public function invoiceStatus(InvoiceStatus $status): self
    {
        $this->parameters['invoice_status'] = $status->value;
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

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function paymentStatus(PaymentStatus ...$value): self
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
        $this->parameters['since_invoice_date'] = $value->format('Y-m-d');
        return $this;
    }

    public function sincePaidAt(DateTimeInterface $value): self
    {
        $this->parameters['since_paid_at'] = $value->format('Y-m-d H:i:s');
        return $this;
    }

    public function sort(OrderSortType $value): self
    {
        $this->parameters['sort'] = $value->value;
        return $this;
    }

    public function source(Source $source): self
    {
        $this->parameters['source'] = $source->value;
        return $this;
    }

    public function untilInvoiceDate(DateTimeInterface $value): self
    {
        $this->parameters['until_invoice_date'] = $value->format('Y-m-d');
        return $this;
    }

    public function untilPaidAt(DateTimeInterface $value): self
    {
        $this->parameters['until_paid_at'] = $value->format('Y-m-d H:i:s');
        return $this;
    }
}
