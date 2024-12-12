<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PortalSetting;

class PortalSettingToBody
{
    public static function build(PortalSetting $rule): array
    {
        $result = [];

        if ($rule->isset('enabled')) {
            $result['enabled'] = $rule->isEnabled();
        }

        if ($rule->isset('readOnly')) {
            $result['read_only'] = $rule->isReadOnly();
        }

        if ($rule->isset('editInvoiceDetails')) {
            $result['edit_invoice_details'] = $rule->isEditInvoiceDetails();
        }

        if ($rule->isset('editPaymentTerm')) {
            $result['edit_payment_term'] = $rule->isEditPaymentTerm();
        }

        if ($rule->isset('editPaymentMethod')) {
            $result['edit_payment_method'] = $rule->isEditPaymentMethod();
        }

        if ($rule->isset('cancelSubscription')) {
            $result['cancel_subscription'] = $rule->isCancelSubscription();
        }

        if ($rule->isset('resumeSubscription')) {
            $result['resume_subscription'] = $rule->isResumeSubscription();
        }

        if ($rule->isset('customColor')) {
            $result['custom_color'] = $rule->getCustomColor();
        }

        if ($rule->isset('hidePoweredBy')) {
            $result['hide_powered_by'] = $rule->isHidePoweredBy();
        }

        if ($rule->isset('externalLogin')) {
            $result['external_login'] = $rule->isExternalLogin();
        }

        return $result;
    }
}
