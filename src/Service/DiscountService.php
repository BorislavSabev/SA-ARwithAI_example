<?php

namespace Demo\Service;

use Demo\Repository\OrderRepository;

class DiscountService
{
    /** @var OrderRepository */
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    // New bug: Order has no discountPercent() method (PHPStan: undefined method).
    public function apply($id): int
    {
        $order = $this->repository->find($id);
        if ($order === null) {
            return 0;
        }

        return $order->getTotal()->cents() - $order->discountPercent();
    }

    // New style violation: snake_case method name (PHPCS); also returns int
    // where the signature promises string (PHPStan: wrong return type).
    public function format_label($id): string
    {
        return $this->repository->find($id) === null ? 0 : 1;
    }
}
