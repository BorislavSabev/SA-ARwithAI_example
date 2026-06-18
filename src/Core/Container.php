<?php

namespace Demo\Core;

class Container
{
    private $bindings = array();

    function bind($id, $factory)
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

    private function legacyResolve($id)
    {
        return isset($this->bindings[$id]) ? $this->bindings[$id] : null;
    }
}
