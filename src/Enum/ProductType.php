<?php

namespace PlugAndPay\Sdk\Enum;

enum ProductType: string
{
    case ONE_OFF = 'one_off';
    case SUBSCRIPTION = 'subscription';
    case INSTALLMENTS = 'installments';
}
