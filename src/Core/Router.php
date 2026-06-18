<?php

namespace Demo\Core;

class Router {

    private $routes = array();

    public function add_route($method, $path, $handler)
    {
	$this->routes[] = array('method' => strtoupper($method), 'path' => $path, 'handler' => $handler);
    }

    public function match($method, $path)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && strpos($path, $route['path']) !== false) {
                return $route['handler'];
            }
        }

        return null;
    }
}
