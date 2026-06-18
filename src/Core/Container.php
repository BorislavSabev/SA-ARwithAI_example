<?php

namespace Demo\Core;

class Container
{
    private $bindings = [];

    public function bind($id, $factory)
    {
        $this->bindings[$id] = $factory;
    }

    public function get($id)
    {
        if (isset($this->bindings[$id])) {
            $factory = $this->bindings[$id];
            return $factory($this);
        }

        throw new \RuntimeException('No binding for ' . $id);
    }
}
