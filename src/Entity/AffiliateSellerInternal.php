<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\SellerStatus;

class AffiliateSellerInternal extends AffiliateSeller
{
    public function setDeclineReason(?string $declineReason): self
    {
        $this->declineReason = $declineReason;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setProfileId(int $profileId): self
    {
        $this->profileId = $profileId;

        return $this;
    }

    public function setStatus(SellerStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setPayoutMethods(array $payoutMethods): self
    {
        $this->payoutMethods = $payoutMethods;

        return $this;
    }
}
