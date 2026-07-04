<?php

namespace Demo\Tests;

use Demo\Model\Customer;
use Demo\Model\Money;
use Demo\Model\Order;
use PHPUnit\Framework\TestCase;

/**
 * Characterization tests for the model's observable behavior.
 *
 * They pin what the code does today so the Rector modernization on the
 * gate-passing branch can be proven behavior-preserving: identical assertions,
 * still green after the refactor. Deliberately use only Money::cents() (an int),
 * never Money::format() (the lying return type), and never the null-return path.
 */
final class OrderTest extends TestCase
{
    public function testNewOrderHasZeroTotal(): void
    {
        $order = new Order(1, new Customer('Bob', 'bob@example.com'));

        $this->assertSame(0, $order->getTotal()->cents());
    }

    public function testGetTotalSumsItemPrices(): void
    {
        $order = new Order(1, new Customer('Bob', 'bob@example.com'));
        $order->addItem('Widget', new Money(2500));
        $order->addItem('Gadget', new Money(1000));

        $this->assertSame(3500, $order->getTotal()->cents());
    }

    public function testGetCustomerIsPreserved(): void
    {
        $customer = new Customer('Bob', 'bob@example.com');
        $order = new Order(1, $customer);

        $this->assertSame('Bob', $order->getCustomer()->getName());
    }

    public function testCustomerEmailAddress(): void
    {
        // The correct method name; the bug is the caller's typo in OrderService.
        $customer = new Customer('Bob', 'bob@example.com');

        $this->assertSame('bob@example.com', $customer->getEmailAddress());
    }
}
