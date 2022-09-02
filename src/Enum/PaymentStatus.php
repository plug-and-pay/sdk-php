<?php

namespace PlugAndPay\Sdk\Enum;

enum PaymentStatus: string
{
    case CREDIT_INVOICE = 'credit_invoice';
    case CREDITED = 'credited';
    case OPEN = 'open';
    case PAID = 'paid';
    case PROCESSING = 'processing';
    case REVERSED = 'reversed';
}
