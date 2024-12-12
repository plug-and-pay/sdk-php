<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\PortalSetting;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToPortalSetting implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    public static function build(array $data): PortalSetting
    {
        return (new PortalSetting())
            ->setEnabled($data['enabled'])
            ->setReadOnly($data['read_only'])
            ->setEditInvoiceDetails($data['edit_invoice_details'])
            ->setEditPaymentTerm($data['edit_payment_term'])
            ->setEditPaymentMethod($data['edit_payment_method'])
            ->setCancelSubscription($data['cancel_subscription'])
            ->setResumeSubscription($data['resume_subscription'])
            ->setCustomColor($data['custom_color'])
            ->setHidePoweredBy($data['hide_powered_by'])
            ->setExternalLogin($data['external_login']);
    }
}
