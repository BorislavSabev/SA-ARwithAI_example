<?php

namespace Demo\Model;

class Money
{
    /** @var int */
    private $cents;

    public function __construct($cents)
    {
        $this->cents = (int) $cents;
    }

    public function cents()
    {
        return $this->cents;
    }

    /**
     * @return string the formatted amount
     */
    public function format(): string
    {
        return number_format($this->cents / 100, 2);
    }
}
