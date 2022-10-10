<?php

/** @noinspection SpellCheckingInspection */

namespace PlugAndPay\Sdk\Enum;

enum PaymentMethod: string
{
    case APPLEPAY       = 'applepay';
    case BANCONTACT     = 'bancontact';
    case BANKTRANSFER   = 'banktransfer';
    case BELFIUS        = 'belfius';
    case CREDITCARD     = 'creditcard';
    case DIRECTDEBIT    = 'directdebit';
    case EPS            = 'eps';
    case GIFTCARD       = 'giftcard';
    case GIROPAY        = 'giropay';
    case IBAN           = 'iban';
    case IDEAL          = 'ideal';
    case IN3            = 'in3';
    case INGHOMEPAY     = 'inghomepay';
    case KBC            = 'kbc';
    case KLARNAPAYLATER = 'klarnapaylater';
    case KLARNAPAYNOW   = 'klarnapaynow';
    case KLARNASLICEIT  = 'klarnasliceit';
    case P24            = 'przelewy24';
    case PAYPAL         = 'paypal';
    case PAYSAFECARD    = 'paysafecard';
    case SOFORT         = 'sofort';
}
