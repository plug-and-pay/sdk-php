<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToPortalSetting;
use PlugAndPay\Sdk\Director\ToBody\PortalSettingToBody;
use PlugAndPay\Sdk\Entity\PortalSetting;

class PortalSettingService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function update(callable $update): PortalSetting
    {
        $portalSetting = new PortalSetting();
        $update($portalSetting);
        $body     = PortalSettingToBody::build($portalSetting);
        $response = $this->client->put('/v2/portal/settings', $body);

        return BodyToPortalSetting::build($response->body()['data']);
    }
}
