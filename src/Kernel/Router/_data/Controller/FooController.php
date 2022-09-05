<?php
declare(strict_types=1);

namespace App\Kernel\Router\_data\Controller;

use App\Kernel\Attribute\Controller;
use App\Kernel\Attribute\Method\Get;
use App\Kernel\Router\_data\Middleware\AuthGuard;
use App\Kernel\Router\_data\Middleware\BarMiddleware;

#[Controller('/foo')]
#[AuthGuard]
class FooController
{
    #[Get(path: '/foo')]
    #[BarMiddleware]
    public function getFoo()
    {
    }
}