# Plug&Pay SDK 
PHP SDK to communicate with Plug&Pay

## Orders

### Show Order

```php
use \PlugAndPay\Sdk\Service\Client;
use \PlugAndPay\Sdk\Service\FetchOrderService;

$client  = new Client($refeshToken);
$service = new FetchOrderService($client);

$order = $service->find(1);

$createdAt     = $order->createdAt();
$deletedAt     = $order->deletedAt();
$id            = $order->id();
$invoiceNumber = $order->invoiceNumber();
$isFirst       = $order->isFirst();
$isHidden      = $order->isHidden();
$invoiceStatus = $order->invoiceStatus();
$mode          = $order->mode();
$reference     = $order->reference();
$source        = $order->source();
$subtotal      = $order->subtotal()->value();
$total         = $order->total()->value();
$updatedAt     = $order->updatedAt()->value();
```

#### Include Order Relationships

All possible relationships:
```php
$service
    ->include(
        \PlugAndPay\Sdk\Enum\OrderIncludes::BILLING,
        \PlugAndPay\Sdk\Enum\OrderIncludes::COMMENTS,
        \PlugAndPay\Sdk\Enum\OrderIncludes::ITEMS,
        \PlugAndPay\Sdk\Enum\OrderIncludes::PAYMENT,
        \PlugAndPay\Sdk\Enum\OrderIncludes::TAGS,
        \PlugAndPay\Sdk\Enum\OrderIncludes::TAXES,
    )
    ->find(1);
```

#### Include Order Billing

```php
$order = $service
    ->include(\PlugAndPay\Sdk\Enum\OrderIncludes::BILLING)
    ->find(1);

$billing = $order->billing();

$company      = $billing->company();
$email        = $billing->email();
$firstName    = $billing->firstName();
$invoiceEmail = $billing->invoiceEmail();
$lastName     = $billing->lastName();
$telephone    = $billing->telephone();
$website      = $billing->website();
$city         = $billing->address()->city();
$country      = $billing->address()->country();
$street       = $billing->address()->street();
$streetSuffix = $billing->address()->streetSuffix();
$zipcode      = $billing->address()->zipcode();
```

#### Include Order Comments

```php
$order = $service
    ->include(\PlugAndPay\Sdk\Enum\OrderIncludes::COMMENTS)
    ->find(1);

$comment = $order->comments()[0];

$createdAt = $comment->createdAt();
$id        = $comment->id();
$updatedAt = $comment->updatedAt();
$value     = $comment->value();
```

#### Include Order Items

```php
$order = $service
    ->include(\PlugAndPay\Sdk\Enum\OrderIncludes::ITEMS)
    ->find(1);

$item = $order->items()[0];

$discount      = $item->discounts()[0]->amount()->value();
$discountCode  = $item->discounts()[0]->code();
$id            = $item->id();
$label         = $item->label();
$productId     = $item->productId();
$quantity      = $item->quantity();
$subtotal      = $item->subtotal()->value();
```

#### Include Order Payment

```php
$order = $service
    ->include(\PlugAndPay\Sdk\Enum\OrderIncludes::PAYMENT)
    ->find(1);

$payment = $order->payment();

$orderId = $payment->orderId();
$paidAt  = $payment->paidAt();
$status  = $payment->status();
$url     = $payment->url();
```

#### Include Order Tags

```php
$order = $service
    ->include(\PlugAndPay\Sdk\Enum\OrderIncludes::TAGS)
    ->find(1);

$tags = $order->tags();
```

#### Include Order Taxes

```php
$order = $service
    ->include(\PlugAndPay\Sdk\Enum\OrderIncludes::TAXES)
    ->find(1);

// All taxes
$tax = $order->taxes()[0];
$tax->amount()->value()
$tax->rate()->percentage()

// Tax per item
$item = $order->items()[0];
$itemTaxValue      = $item->tax()->amount()->value();
$itemTaxPercentage = $item->tax()->rate()->percentage();
```

### Index Orders
When retrieving multiple orders, you can load the same relations as in [Show Orders](#Include Order Relationships). You can also specify filter parameters.

```php
use \PlugAndPay\Sdk\Enum\OrderIncludes;
use \PlugAndPay\Sdk\Service\Client;
use \PlugAndPay\Sdk\Service\FetchOrderService;

$client  = new Client($refeshToken);
$service = new FetchOrderService($client);

$orders = $service->include(OrderIncludes::BILLING, OrderIncludes::COMMENTS)->get();
```

#### Filter Orders

```php
use \PlugAndPay\Sdk\Service\Client;
use \PlugAndPay\Sdk\Service\FetchOrderService;

$client  = new Client($refeshToken);
$service = new FetchOrderService($client);

/** @var Order[] $orders */
$orders = $service->get(function(OrderFilter $filter) {
    $filter
      ->affiliate_id(1234)
      ->checkout_id(1234)
      ->contract_id(1234)
      ->contract_type(...)
      ->country(...)
      ->direction(...)
      ->discount_code(...)
      ->email(...)
      ->has_bump(...)
      ->has_tax(...)
      ->include(...)
      ->invoice_status(...)
      ->is_deleted(...)
      ->is_first(...)
      ->is_hidden(...)
      ->is_upsell(...)
      ->limit(...)
      ->mode(...)
      ->page(...)
      ->payment_status(...)
      ->product_id(1234)
      ->product_tag(...)
      ->q(...)
      ->since_invoice_date(...)
      ->since_paid_at(...)
      ->sort(...)
      ->source(...)
      ->until_invoice_date(...)
      ->until_paid_at(...)
});
```

### Create Order
When creating an order, you can load the same relations as in [Show Orders](#Include Order Relationships).

```php
use \PlugAndPay\Sdk\Entity\Address;
use \PlugAndPay\Sdk\Entity\Billing;
use \PlugAndPay\Sdk\Entity\Comment;
use \PlugAndPay\Sdk\Entity\Item;
use \PlugAndPay\Sdk\Entity\Money;
use \PlugAndPay\Sdk\Entity\Order;
use \PlugAndPay\Sdk\Entity\Payment;
use \PlugAndPay\Sdk\Enum\OrderIncludes;
use \PlugAndPay\Sdk\Enum\PaymentStatus;
use \PlugAndPay\Sdk\Enum\TaxExempt;
use \PlugAndPay\Sdk\Service\Client;
use \PlugAndPay\Sdk\Service\StoreOrderService;

$client  = new Client($refeshToken);
$service = new StoreOrderService($client);
$order = (new Order())
    ->taxExempt(TaxExempt::REVERSE)
    ->setTaxIncluded(true)
    ->setHidden(false)
    ->setBilling(
        (new Billing())
            ->setAddress(
                (new Address(...))
                    ->setCity(...)
                    ->setCountry(...)
                    ->setStreet(...)
                    ->setStreetSuffix(...)
                    ->setZipcode(...)
            )
            ->setCompany(...)
            ->setEmail('rosalie39@example.net')
            ->setFirstName('Bilal')
            ->setInvoiceEmail(...)
            ->setLastName('de Wit')
            ->setTelephone(...)
            ->setWebsite(...)
    )
    ->setComments([
        (new Comment())->setValue('the comment'),
    ])
    ->setItems([
        (new Item())
            ->setAmount(new Money(10.))
            ->setLabel('the-label')
            ->setQuantity(2)
            ->setTaxByRateId(123)
            ->setProductId(123),
    ])
    ->setPayment((new Payment())->setStatus(PaymentStatus::PROCESSING))
    ->setTags(['first_tag', 'second_tag']);

$order = $service->create($order);
$orderId = $order->id();
```

### Update Order
When creating an order, you can load the same relations as in [Show Orders](#Include Order Relationships).

```php
use \PlugAndPay\Sdk\Entity\Order;
use \PlugAndPay\Sdk\Enum\OrderIncludes;
use \PlugAndPay\Sdk\Service\Client;
use \PlugAndPay\Sdk\Service\StoreOrderService;

$client  = new Client($refeshToken);
$service = new StoreOrderService($client);
$orderId = 12;

$order = $service->update($orderId, function(Order $order) {
    $order->setTags(['first_tag', 'second_tag']);
})
```
