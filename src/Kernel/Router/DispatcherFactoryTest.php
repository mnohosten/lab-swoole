<?php
declare(strict_types=1);

namespace App\Kernel\Router;

use FastRoute\Dispatcher;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class DispatcherFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $dispatcher = DispatcherFactory::create(__DIR__ . '/_data');
        Assert::assertInstanceOf(Dispatcher::class, $dispatcher);
    }
}
