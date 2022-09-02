<?php

namespace PlugAndPay\Sdk\Enum;

enum ProductType: string
{
    case INSTALLMENTS = 'installments';
    case ONE_OFF = 'one_off';
    case SUBSCRIPTION = 'subscription';
}
