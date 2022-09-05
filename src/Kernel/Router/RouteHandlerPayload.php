<?php
declare(strict_types=1);

namespace App\Kernel\Router;

class RouteHandlerPayload
{
    public function __construct(
        public readonly string $method,
        public readonly string $route,
        public readonly \ReflectionMethod $reflectionMethod,
        public readonly array $middlewares = [],
    )
    {
    }
}
