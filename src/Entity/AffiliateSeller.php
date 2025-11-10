<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\SellerStatus;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Traits\HasDynamicFields;

class AffiliateSeller extends AbstractEntity
{
    use HasDynamicFields;

    protected bool $allowEmptyRelations;
    protected Address $address;
    protected Contact $contact;
    protected ?string $declineReason;
    protected int $id;
    protected string $name;
    protected string $email;
    protected SellerProfile $profile;
    protected int $profileId;
    protected SellerStatistics $statistics;
    protected SellerStatus $status;
    protected SellerPayoutOptions $payoutOptions;
    /** @var PayoutMethod[] */
    protected array $payoutMethods;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function address(): Address
    {
        if (!isset($this->address)) {
            if ($this->allowEmptyRelations) {
                $this->address = new Address();
            } else {
                throw new RelationNotLoadedException('address');
            }
        }

        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function contact(): Contact
    {
        if (!isset($this->contact)) {
            if ($this->allowEmptyRelations) {
                $this->contact = new Contact();
            } else {
                throw new RelationNotLoadedException('contact');
            }
        }

        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function declineReason(): ?string
    {
        return $this->declineReason;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function profile(): SellerProfile
    {
        if (!isset($this->profile)) {
            if ($this->allowEmptyRelations) {
                $this->profile = new SellerProfile();
            } else {
                throw new RelationNotLoadedException('profile');
            }
        }

        return $this->profile;
    }

    public function setProfile(SellerProfile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function profileId(): int
    {
        return $this->profileId;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function statistics(): SellerStatistics
    {
        if (!isset($this->statistics)) {
            if ($this->allowEmptyRelations) {
                $this->statistics = new SellerStatistics();
            } else {
                throw new RelationNotLoadedException('statistics');
            }
        }

        return $this->statistics;
    }

    public function setStatistics(SellerStatistics $statistics): self
    {
        $this->statistics = $statistics;

        return $this;
    }

    public function status(): SellerStatus
    {
        return $this->status;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function payoutOptions(): SellerPayoutOptions
    {
        if (!isset($this->payoutOptions)) {
            if ($this->allowEmptyRelations) {
                $this->payoutOptions = new SellerPayoutOptions();
            } else {
                throw new RelationNotLoadedException('payoutOptions');
            }
        }

        return $this->payoutOptions;
    }

    public function setPayoutOptions(SellerPayoutOptions $payoutOptions): self
    {
        $this->payoutOptions = $payoutOptions;

        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     * @return PayoutMethod[]
     */
    public function payoutMethods(): array
    {
        if (!isset($this->payoutMethods)) {
            if ($this->allowEmptyRelations) {
                $this->payoutMethods = [];
            } else {
                throw new RelationNotLoadedException('payoutMethods');
            }
        }

        return $this->payoutMethods;
    }
}
