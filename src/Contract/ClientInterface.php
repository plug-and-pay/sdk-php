<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Contract;

interface ClientInterface extends ClientPatchInterface, ClientPostInterface, ClientGetInterface, ClientDeleteInterface
{
}
