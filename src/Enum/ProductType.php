<?php

namespace PlugAndPay\Sdk\Enum;

class ProductType
{
    public const INSTALLMENTS = 'installments';
    public const ONE_OFF = 'one_off';
    public const SUBSCRIPTION = 'subscription';

    public const CASES = [
        self::INSTALLMENTS,
        self::ONE_OFF,
        self::SUBSCRIPTION,
    ];
}
