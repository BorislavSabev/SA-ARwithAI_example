<?php

namespace Demo\Model;

class Order
{
    private $id;
    private $customer;
    private $items;
    private $paid;

    public function __construct($id, Customer $customer)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->items = array();
        $this->paid = false;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function addItem($label, Money $price)
    {
        $this->items[] = array('label' => $label, 'price' => $price);
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
