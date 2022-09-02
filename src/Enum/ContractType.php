<?php

namespace PlugAndPay\Sdk\Enum;

enum ContractType: string
{
    case SUBSCRIPTION = 'subscription';
    case INSTALLMENTS = 'installments';
    case ONE_OFF = 'one_off';
}
