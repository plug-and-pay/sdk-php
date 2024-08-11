<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class SubscriptionBilling
{
    use ValidatesFieldMethods;

    private bool $allowEmptyRelations;
    private Address $address;
    private Contact $contact;
    private SubscriptionBillingSchedule $schedule;
    private SubscriptionPaymentOptions $paymentOptions;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function address(): Address
    {
        if ($this->allowEmptyRelations && !$this->isset('address')) {
            $this->address = new Address();
        }

        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function contact(): Contact
    {
        if ($this->allowEmptyRelations && !$this->isset('contact')) {
            $this->contact = new Contact();
        }

        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function schedule(): SubscriptionBillingSchedule
    {
        if ($this->allowEmptyRelations && !$this->isset('schedule')) {
            $this->schedule = new SubscriptionBillingSchedule();
        }

        return $this->schedule;
    }

    public function setSchedule(SubscriptionBillingSchedule $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function paymentOptions(): SubscriptionPaymentOptions
    {
        if ($this->allowEmptyRelations && !$this->isset('paymentOptions')) {
            $this->paymentOptions = new SubscriptionPaymentOptions();
        }

        return $this->paymentOptions;
    }

    public function setPaymentOptions(SubscriptionPaymentOptions $paymentOptions): self
    {
        $this->paymentOptions = $paymentOptions;

        return $this;
    }
}
