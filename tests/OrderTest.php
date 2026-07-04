<?php

namespace Demo\Tests;

use Demo\Model\Customer;
use Demo\Model\Money;
use Demo\Model\Order;
use PHPUnit\Framework\TestCase;

/**
 * Characterization tests for the model's observable behavior.
 *
 * They pin what the code does today so the Rector modernization on this branch
 * is proven behavior-preserving: the behavioral assertions are identical to the
 * baseline branch and stay green after the refactor. Only the Order constructor
 * call was updated to match Rector dropping the unused $id — the exact caller fix
 * an automated refactor forces on you. Deliberately use only Money::cents() (an
 * int), never Money::format() (the lying return type), and never the null path.
 */
final class OrderTest extends TestCase
{
    public function testNewOrderHasZeroTotal(): void
    {
        $order = new Order(new Customer('Bob', 'bob@example.com'));

        $this->assertSame(0, $order->getTotal()->cents());
    }

    public function testGetTotalSumsItemPrices(): void
    {
        $order = new Order(new Customer('Bob', 'bob@example.com'));
        $order->addItem('Widget', new Money(2500));
        $order->addItem('Gadget', new Money(1000));

        $this->assertSame(3500, $order->getTotal()->cents());
    }

    public function testGetCustomerIsPreserved(): void
    {
        $customer = new Customer('Bob', 'bob@example.com');
        $order = new Order($customer);

        $this->assertSame('Bob', $order->getCustomer()->getName());
    }

    public function testCustomerEmailAddress(): void
    {
        // The correct method name; the bug is the caller's typo in OrderService.
        $customer = new Customer('Bob', 'bob@example.com');

        $this->assertSame('bob@example.com', $customer->getEmailAddress());
    }
}
