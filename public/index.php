<?php

require __DIR__ . '/../vendor/autoload.php';

use Demo\Core\Container;
use Demo\Core\Router;
use Demo\Repository\OrderRepository;
use Demo\Service\OrderService;

$container = new Container();
$container->bind('orders', function () {
    return new OrderService(new OrderRepository());
});

$router = new Router();
$router->addRoute('GET', '/summary', function () use ($container) {
    /** @var OrderService $service */
    $service = $container->get('orders');
    return $service->status(new \Demo\Model\Order(new \Demo\Model\Customer('Bob', 'bob@example.com')));
});

$handler = $router->match('GET', '/summary');
echo $handler === null ? "no route\n" : $handler() . "\n";
