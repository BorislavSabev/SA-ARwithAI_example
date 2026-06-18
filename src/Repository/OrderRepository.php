<?php

namespace Demo\Repository;

use Demo\Model\Customer;
use Demo\Model\Money;
use Demo\Model\Order;

class OrderRepository
{
    /** @var array<int, Order> */
    private $orders = [];

    public function __construct()
    {
        $alice = new Customer('Alice', 'alice@example.com');
        $order = new Order($alice);
        $order->addItem('Widget', new Money(2500));
        $this->orders[1] = $order;
    }

    public function find($id): ?Order
    {
        return $this->orders[$id] ?? null;
    }
}
