<?php
declare(strict_types=1);

namespace App\Kernel\Router;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class RouteCollectionFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $routes = RouteCollectionFactory::create(__DIR__ . '/_data');
        Assert::assertEquals(1, count($routes));
        foreach ($routes as $key=>$route) {
            Assert::assertInstanceOf(RouteHandlerPayload::class, $route);
            Assert::assertEquals('GET', $route->method);
            Assert::assertEquals('/foo/foo', $route->route);
            Assert::assertEquals('App\Kernel\Router\_data\Controller\FooController::getFoo', $key);
        }
    }
}
