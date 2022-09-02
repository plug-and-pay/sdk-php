<?php

namespace PlugAndPay\Sdk\Enum;

enum PaymentType: string
{
    case MAIL = 'mail';
    case MANDATE = 'mandate';
    case MANUAL = 'manual';
}
