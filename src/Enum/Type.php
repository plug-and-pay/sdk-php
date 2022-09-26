<?php

namespace PlugAndPay\Sdk\Enum;

enum Type: string
{
    case ONE_OFF = 'one_off';
    case SUBSCRIPTION = 'subscription';
    case INSTALLMENTS = 'installments';
}
