<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Money;
use PlugAndPay\Sdk\Entity\Rate;
use PlugAndPay\Sdk\Entity\Tax;

class ResponseToTax
{
    /**
     * @return Tax[]
     */
    public function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $tax) {
            $result[] = $this->build($tax);
        }
        return $result;
    }

    public function build(array $data): Tax
    {
        return (new Tax())
            ->setAmount(new Money((float)$data['amount']['value'], $data['amount']['currency']))
            ->setRate(new Rate($data['rate']['percentage'], $data['rate']['country']));
    }
}
