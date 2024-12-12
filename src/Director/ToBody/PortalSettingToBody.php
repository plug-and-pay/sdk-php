<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PortalSetting;

class PortalSettingToBody
{
    public static function build(PortalSetting $portalSetting): array
    {
        $result = [];

        if ($portalSetting->isset('enabled')) {
            $result['enabled'] = $portalSetting->isEnabled();
        }

        if ($portalSetting->isset('readOnly')) {
            $result['read_only'] = $portalSetting->isReadOnly();
        }

        if ($portalSetting->isset('editInvoiceDetails')) {
            $result['edit_invoice_details'] = $portalSetting->isEditInvoiceDetails();
        }

        if ($portalSetting->isset('editPaymentTerm')) {
            $result['edit_payment_term'] = $portalSetting->isEditPaymentTerm();
        }

        if ($portalSetting->isset('editPaymentMethod')) {
            $result['edit_payment_method'] = $portalSetting->isEditPaymentMethod();
        }

        if ($portalSetting->isset('cancelSubscription')) {
            $result['cancel_subscription'] = $portalSetting->isCancelSubscription();
        }

        if ($portalSetting->isset('resumeSubscription')) {
            $result['resume_subscription'] = $portalSetting->isResumeSubscription();
        }

        if ($portalSetting->isset('customColor')) {
            $result['custom_color'] = $portalSetting->getCustomColor();
        }

        if ($portalSetting->isset('hidePoweredBy')) {
            $result['hide_powered_by'] = $portalSetting->isHidePoweredBy();
        }

        if ($portalSetting->isset('externalLogin')) {
            $result['external_login'] = $portalSetting->isExternalLogin();
        }

        return $result;
    }
}
