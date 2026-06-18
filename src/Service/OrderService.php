<?php

namespace Demo\Service;

use Demo\Model\Order;
use Demo\Repository\OrderRepository;

class OrderService
{
    /** @var OrderRepository */
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    // Scary #1: getEmailAdress() does not exist (typo for getEmailAddress()).
    public function summary($id): string
    {
        $order = $this->repository->find($id);

        return $order->getCustomer()->getEmailAdress();
    }

    // Scary #2: declared : int but Money::format() returns string.
    public function totalCents($id): int
    {
        $order = $this->repository->find($id);

        return $order->getTotal()->format();
    }

    // Scary #3: find() may return null; no guard before getTotal().
    public function reprice($id): int
    {
        $order = $this->repository->find($id);

        return $order->getTotal()->cents() * 2;
    }

    // Dead code: the second branch is unreachable.
    public function status(Order $order): string
    {
        if ($order->isPaid()) {
            return 'paid';
        }

        return 'unpaid';

        return 'unknown';
    }
}
