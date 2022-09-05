<?php
declare(strict_types=1);

namespace App\Kernel\Router;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class DispatcherFactory
{
    public static function create(string $path): Dispatcher
    {
        $routes = RouteCollectionFactory::create($path);
        return simpleDispatcher(function(RouteCollector $r) use ($routes) {
            foreach ($routes as $route) {
                $r->addRoute(
                    $route->method,
                    $route->route,
                    $route
                );
            }
        });
    }
}