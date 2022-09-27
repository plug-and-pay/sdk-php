<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Subscription;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Type;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\SubscriptionIncludes;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Service\SubscriptionService;
use PlugAndPay\Sdk\Tests\Feature\Subscription\Mock\SubscriptionShowMockClient;

class ShowSubscriptionTest extends TestCase
{
    /** @test */
    public function show_basic_subscription(): void
    {
        $client = new SubscriptionShowMockClient(['id' => 1]);
        $service = new SubscriptionService($client);

        $subscription = $service->find(1);

        static::assertSame(1, $subscription->id());
        static::assertNull($subscription->cancelledAt());
        static::assertSame('2022-09-20 08:15:24', $subscription->createdAt()->format('Y-m-d H:i:s'));
        static::assertNull($subscription->deletedAt());
        static::assertSame(Mode::LIVE, $subscription->mode());
        static::assertSame(Source::API, $subscription->source());
        static::assertSame(SubscriptionStatus::ACTIVE, $subscription->status());
        static::assertSame('2022-09-20 08:15:24', $subscription->createdAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     * @dataProvider relationsProvider
     */
    public function show_none_loaded_relationships(string $relation): void
    {
        $exception = null;

        try {
            (new Subscription(false))->{$relation}();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /**
     * Data provider for show_none_loaded_relationships
     */
    public function relationsProvider(): array
    {
        return [
            'billing' => ['billing'],
            'pricing' => ['pricing'],
            'product' => ['product'],
            'tags'    => ['tags'],
            'trial'   => ['trial'],
        ];
    }

    /** @test */
    public function show_subscription_with_billing_address_and_contact(): void
    {
        $client = (new SubscriptionShowMockClient())->billing();
        $service = new SubscriptionService($client);

        $subscription = $service->include(SubscriptionIncludes::BILLING)->find(1);
        $billing = $subscription->billing();

        $contact = $billing->contact();
        static::assertSame('Café Timmermans & Zn', $contact->company());
        static::assertSame('rosalie39@example.net', $contact->email());
        static::assertSame('Bilal', $contact->firstName());
        static::assertSame('de Wit', $contact->lastName());
        static::assertSame('(044) 4362837', $contact->telephone());
        static::assertSame('https://www.vandewater.nl/velit-porro-ut-velit-soluta.html', $contact->website());
        static::assertSame('NL000099998B57', $contact->vatIdNumber());

        $address = $billing->address();
        static::assertSame('\'t Veld', $address->city());
        static::assertSame(CountryCode::NL, $address->country());
        static::assertSame('Sanderslaan', $address->street());
        static::assertSame('42', $address->houseNumber());
        static::assertSame('1448VB', $address->zipcode());
    }

    /** @test */
    public function show_subscription_with_pricing(): void
    {
        $client = (new SubscriptionShowMockClient())->pricing();
        $service = new SubscriptionService($client);

        $subscription = $service->include(SubscriptionIncludes::PRICING)->find(1);

        $pricing = $subscription->pricing();
        static::assertSame('100.00', $pricing->amount());
        static::assertSame('121.00', $pricing->amountWithTax());
        static::assertSame([], $pricing->discounts());
        static::assertSame(10, $pricing->quantity());
        static::assertTrue($pricing->isTaxIncluded());
    }

    /** @test */
    public function show_subscription_with_product(): void
    {
        $client = (new SubscriptionShowMockClient())->product();
        $service = new SubscriptionService($client);

        $subscription = $service->include(SubscriptionIncludes::PRODUCT)->find(1);

        $product = $subscription->product();
        static::assertSame('2019-01-16 00:00:00', $product->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $product->deletedAt()->format('Y-m-d H:i:s'));
        static::assertSame('Quisquam recusandae asperiores accusamus', $product->description());
        static::assertSame(1, $product->id());
        static::assertFalse($product->isPhysical());
        static::assertNull($product->ledger());
        static::assertSame('culpa', $product->publicTitle());
        static::assertSame('70291520', $product->sku());
        static::assertNull($product->slug());
        static::assertSame('culpa', $product->title());
        static::assertSame(Type::ONE_OFF, $product->type());
        static::assertSame('2019-01-16 00:00:00', $product->updatedAt()->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function show_subscription_with_tags(): void
    {
        $client = (new SubscriptionShowMockClient())->tags(['first', 'second']);
        $service = new SubscriptionService($client);

        $subscription = $service->include(SubscriptionIncludes::TAGS)->find(1);

        static::assertSame(['first', 'second'], $subscription->tags());
    }

    /** @test */
    public function show_subscription_with_trial(): void
    {
        $client = (new SubscriptionShowMockClient())->trial();
        $service = new SubscriptionService($client);

        $subscription = $service->include(SubscriptionIncludes::TRIAL)->find(1);

        $trial = $subscription->trial();
        static::assertSame('2019-01-16 00:00:00', $trial->startDate()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $trial->endDate()->format('Y-m-d H:i:s'));
        static::assertTrue($trial->isActive());
    }
}
