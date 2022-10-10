<?php

namespace PlugAndPay\Sdk\Enum;

enum InvoiceStatus: string
{
    case FINAL   = 'final';
    case CONCEPT = 'concept';
}
