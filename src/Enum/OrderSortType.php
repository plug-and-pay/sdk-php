<?php

namespace PlugAndPay\Sdk\Enum;

enum OrderSortType: string
{
    case PAID_AT = 'paid_at';
    case INVOICE_NUMBER = 'invoice_number';
    case INVOICE_DATE = 'invoice_date';
}
