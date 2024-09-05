<?php

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Checkout;

class CheckoutToBody
{
    public static function build(Checkout $checkout): array
    {
        $result = [];

        if ($checkout->isset('isActive')) {
            $result['is_active'] = $checkout->isActive();
        }

        if ($checkout->isset('isExpired')) {
            $result['is_expired'] = $checkout->isExpired();
        }

        if ($checkout->isset('name')) {
            $result['name'] = $checkout->name();
        }

        if ($checkout->isset('previewUrl')) {
            $result['preview_url'] = $checkout->previewUrl();
        }

        if ($checkout->isset('primaryColor')) {
            $result['primary_color'] = $checkout->primaryColor();
        }

        if ($checkout->isset('product')) {
            $result['product'] = ProductToBody::build($checkout->product());
        }

        if ($checkout->isset('returnUrl')) {
            $result['return_url'] = $checkout->returnUrl();
        }

        if ($checkout->isset('secondaryColor')) {
            $result['secondary_color'] = $checkout->secondaryColor();
        }

        if ($checkout->isset('slug')) {
            $result['slug'] = $checkout->slug();
        }

        if ($checkout->isset('url')) {
            $result['url'] = $checkout->url();
        }

        return $result;
    }
}
