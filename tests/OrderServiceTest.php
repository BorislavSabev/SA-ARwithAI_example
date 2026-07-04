<?php

namespace Demo\Tests;

use Demo\Model\Customer;
use Demo\Model\Order;
use Demo\Repository\OrderRepository;
use Demo\Service\OrderService;
use PHPUnit\Framework\TestCase;

/**
 * Smoke tests for the happy path the app actually exercises
 * (public/index.php -> OrderService::status()).
 *
 * These pass on the flawed baseline ON PURPOSE. The three "scary" bugs
 * (summary(), totalCents(), reprice()) live in code paths these tests never
 * touch — which is exactly why static analysis, not tests, is what catches them.
 */
final class OrderServiceTest extends TestCase
{
    private function service(): OrderService
    {
        return new OrderService(new OrderRepository());
    }

    private function order(): Order
    {
        return new Order(new Customer('Bob', 'bob@example.com'));
    }

    public function testNewOrderIsUnpaid(): void
    {
        $this->assertSame('unpaid', $this->service()->status($this->order()));
    }

    public function testPaidOrderReportsPaid(): void
    {
        $order = $this->order();
        $order->markPaid();

        $this->assertSame('paid', $this->service()->status($order));
    }
}
