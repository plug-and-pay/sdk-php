<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\HasDynamicFields;

class PortalSetting extends AbstractEntity
{
    use HasDynamicFields;

    protected bool $enabled;
    protected bool $readOnly;
    protected bool $editInvoiceDetails;
    protected bool $editPaymentTerm;
    protected bool $editPaymentMethod;
    protected bool $cancelSubscription;
    protected bool $resumeSubscription;
    protected ?string $customColor;
    protected ?bool $hidePoweredBy;
    protected bool $externalLogin;

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    public function setReadOnly(bool $readOnly): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    public function isEditInvoiceDetails(): bool
    {
        return $this->editInvoiceDetails;
    }

    public function setEditInvoiceDetails(bool $editInvoiceDetails): self
    {
        $this->editInvoiceDetails = $editInvoiceDetails;

        return $this;
    }

    public function isEditPaymentTerm(): bool
    {
        return $this->editPaymentTerm;
    }

    public function setEditPaymentTerm(bool $editPaymentTerm): self
    {
        $this->editPaymentTerm = $editPaymentTerm;

        return $this;
    }

    public function isEditPaymentMethod(): bool
    {
        return $this->editPaymentMethod;
    }

    public function setEditPaymentMethod(bool $editPaymentMethod): self
    {
        $this->editPaymentMethod = $editPaymentMethod;

        return $this;
    }

    public function isCancelSubscription(): bool
    {
        return $this->cancelSubscription;
    }

    public function setCancelSubscription(bool $cancelSubscription): self
    {
        $this->cancelSubscription = $cancelSubscription;

        return $this;
    }

    public function isResumeSubscription(): bool
    {
        return $this->resumeSubscription;
    }

    public function setResumeSubscription(bool $resumeSubscription): self
    {
        $this->resumeSubscription = $resumeSubscription;

        return $this;
    }

    public function getCustomColor(): ?string
    {
        return $this->customColor;
    }

    public function setCustomColor(?string $customColor): self
    {
        $this->customColor = $customColor;

        return $this;
    }

    public function isHidePoweredBy(): ?bool
    {
        return $this->hidePoweredBy;
    }

    public function setHidePoweredBy(?bool $hidePoweredBy): self
    {
        $this->hidePoweredBy = $hidePoweredBy;

        return $this;
    }

    public function isExternalLogin(): bool
    {
        return $this->externalLogin;
    }

    public function setExternalLogin(bool $externalLogin): self
    {
        $this->externalLogin = $externalLogin;

        return $this;
    }
}
