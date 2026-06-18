<?php

namespace Demo\Core;

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $handler)
    {
        $this->routes[] = ['method' => strtoupper((string) $method), 'path' => $path, 'handler' => $handler];
    }

    public function match($method, $path)
    {
        $wanted = strtoupper((string) $method);
        foreach ($this->routes as $route) {
            $pathMatches = str_contains((string) $path, (string) $route['path']);
            if ($route['method'] === $wanted && $pathMatches) {
                return $route['handler'];
            }
        }

        return null;
    }
}
