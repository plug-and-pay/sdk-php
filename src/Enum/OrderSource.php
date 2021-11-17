<?php

namespace PlugAndPay\Sdk\Enum;

class OrderSource
{
    public const ADMIN = 'admin';
    public const API = 'api';
    public const CHECKOUT = 'checkout';
    public const IMPORT = 'import';
    public const RECURRING = 'recurring';
    public const UPGRADE = 'upgrade';
    public const UPSELL = 'upsell';
    public const UNKNOWN = 'unknown';
}
