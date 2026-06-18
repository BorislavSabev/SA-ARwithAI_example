<?php

namespace Demo\Model;

class Customer
{
    public function __construct(private readonly string $name, private readonly string $email)
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmailAddress(): string
    {
        return $this->email;
    }
}
