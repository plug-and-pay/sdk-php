<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\OrderToBody;
use PlugAndPay\Sdk\Entity\Address;
use PlugAndPay\Sdk\Entity\Billing;
use PlugAndPay\Sdk\Entity\Item;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Service\StoreOrderService;

class StoreOrdersTest extends TestCase
{
    /** @test */
    public function convert_basic_order_to_body(): void
    {
        $body = OrderToBody::build($this->generateOrder());

        static::assertEquals([
            'billing'         => [
                'address'    => [
                    'country' => 'NL',
                ],
                'email'      => 'rosalie39@example.net',
                'first_name' => 'Bilal',
                'last_name'  => 'de Wit',
            ],
            'is_tax_included' => true,
            'items'           => [
                [
                    'label' => 'the-label',
                ],
            ],
        ], $body);
    }

    /**
     * @test
     */
    public function convert_order_without_filled_order(): void
    {
        $body = OrderToBody::build(new Order());

        static::assertEquals([], $body);
    }

    /** @test */
    public function store_basic_order(): void
    {
        $client  = new OrderStoreClientMock();
        $service = new StoreOrderService($client);

        $order = $service->post($this->generateOrder());

        static::assertEquals(1, $order->id());
    }

    private function generateBilling(): Billing
    {
        return (new Billing())
            ->setAddress((new Address())->setCountry('NL'))
            ->setEmail('rosalie39@example.net')
            ->setFirstName('Bilal')
            ->setLastName('de Wit');
    }

    private function generateOrder(): Order
    {
        $item = (new Item())->setLabel('the-label');

        return (new Order())
            ->setBilling($this->generateBilling())
            ->setTaxIncluded(true)
            ->setItems([$item]);
    }
}
