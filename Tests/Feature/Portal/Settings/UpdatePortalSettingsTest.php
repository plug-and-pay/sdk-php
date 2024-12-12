<?php

namespace PlugAndPay\Sdk\Tests\Feature\Portal\Settings;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\PortalSetting;
use PlugAndPay\Sdk\Service\PortalSettingService;
use PlugAndPay\Sdk\Tests\Feature\Portal\Settings\Mock\PortalSettingsUpdateMockClient;

class UpdatePortalSettingsTest extends TestCase
{
    /**
     * @test
     * @dataProvider update_portal_boolean_settings_provider
     */
    public function update_portal_boolean_settings(string $getter, string $setter): void
    {
        $client  = new PortalSettingsUpdateMockClient();
        $service = new PortalSettingService($client);

        $settings = $service->update(function (PortalSetting $settings) use ($setter) {
            $settings->$setter(true);
        });

        static::assertTrue($settings->$getter());
    }

    public static function update_portal_boolean_settings_provider(): array
    {
        return [
            ['isEnabled', 'setEnabled'],
            ['isReadOnly', 'setReadOnly'],
            ['isEditInvoiceDetails', 'setEditInvoiceDetails'],
            ['isEditPaymentTerm', 'setEditPaymentTerm'],
            ['isEditPaymentMethod', 'setEditPaymentMethod'],
            ['isCancelSubscription', 'setCancelSubscription'],
            ['isResumeSubscription', 'setResumeSubscription'],
            ['isHidePoweredBy', 'setHidePoweredBy'],
            ['isExternalLogin', 'setExternalLogin'],
        ];
    }

    /** @test */
    public function update_custom_color_false(): void
    {
        $client  = new PortalSettingsUpdateMockClient();
        $service = new PortalSettingService($client);

        $settings = $service->update(function (PortalSetting $settings) {
            $settings->setEnabled(false);
        });

        static::assertFalse($settings->isEnabled());
    }

    /** @test */
    public function update_custom_color(): void
    {
        $client  = new PortalSettingsUpdateMockClient();
        $service = new PortalSettingService($client);

        $settings = $service->update(function (PortalSetting $settings) {
            $settings->setCustomColor('#ffffff');
        });

        static::assertEquals('#ffffff', $settings->getCustomColor());
    }
}
