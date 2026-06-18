<?php

namespace Demo\Repository;

use Demo\Model\Customer;
use Demo\Model\Money;
use Demo\Model\Order;

class OrderRepository
{
    /** @var array<int, Order> */
    private $orders = array();

    public function __construct()
    {
        $alice = new Customer('Alice', 'alice@example.com');
        $order = new Order(1, $alice);
        $order->addItem('Widget', new Money(2500));
        $this->orders[1] = $order;
    }

    /**
     * @return Order|null
     */
    public function find($id): ?Order
    {
        return isset($this->orders[$id]) ? $this->orders[$id] : null;
    }
}
