<?php

namespace Demo\Model;

class Order
{
    private $items = [];
    private $paid = false;

    public function __construct(private readonly Customer $customer)
    {
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function addItem($label, Money $price)
    {
        $this->items[] = ['label' => $label, 'price' => $price];
    }

    public function getTotal(): Money
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item['price']->cents();
        }

        return new Money($sum);
    }

    public function markPaid()
    {
        $this->paid = true;
    }

    public function isPaid()
    {
        return $this->paid;
    }
}
