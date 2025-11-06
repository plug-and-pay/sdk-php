<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\AffiliateSeller;
use PlugAndPay\Sdk\Entity\AffiliateSellerInternal;
use PlugAndPay\Sdk\Enum\SellerStatus;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToAffiliateSeller implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    public static function build(array $data): AffiliateSeller
    {
        $seller = (new AffiliateSellerInternal(false))
            ->setId($data['id'])
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setDeclineReason($data['decline_reason'] ?? null)
            ->setProfileId($data['profile_id'])
            ->setStatus(SellerStatus::from($data['status']));

        if (isset($data['address'])) {
            $seller->setAddress(BodyToAddress::build($data['address']));
        }

        if (isset($data['contact'])) {
            $seller->setContact(BodyToContact::build($data['contact']));
        }

        if (isset($data['profile'])) {
            $seller->setProfile(BodyToSellerProfile::build($data['profile']));
        }

        if (isset($data['statistics'])) {
            $seller->setStatistics(BodyToSellerStatistics::build($data['statistics']));
        }

        if (isset($data['payout_options'])) {
            $seller->setPayoutOptions(BodyToSellerPayoutOptions::build($data['payout_options']));
        }

        if (isset($data['payout_methods'])) {
            $seller->setPayoutMethods(BodyToPayoutMethod::buildMulti($data['payout_methods']));
        }

        return $seller;
    }
}
