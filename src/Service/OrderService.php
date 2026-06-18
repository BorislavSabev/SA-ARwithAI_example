<?php

namespace Demo\Service;

use Demo\Model\Order;
use Demo\Repository\OrderRepository;

class OrderService
{
    public function __construct(private readonly OrderRepository $repository)
    {
    }

    public function summary($id): string
    {
        $order = $this->repository->find($id);
        if (!$order instanceof \Demo\Model\Order) {
            return '';
        }

        return $order->getCustomer()->getEmailAddress();
    }

    public function totalCents($id): int
    {
        $order = $this->repository->find($id);
        if (!$order instanceof \Demo\Model\Order) {
            return 0;
        }

        return $order->getTotal()->cents();
    }

    public function reprice($id): int
    {
        $order = $this->repository->find($id);
        if (!$order instanceof \Demo\Model\Order) {
            return 0;
        }

        return $order->getTotal()->cents() * 2;
    }

    public function status(Order $order): string
    {
        if ($order->isPaid()) {
            return 'paid';
        }

        return 'unpaid';
    }
}
