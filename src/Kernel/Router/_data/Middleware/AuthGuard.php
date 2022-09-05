<?php
declare(strict_types=1);

namespace App\Kernel\Router\_data\Middleware;

use App\Kernel\Attribute\Middleware\Middleware;
use Swoole\Http\Request;
use Swoole\Http\Response;

#[\Attribute]
class AuthGuard extends Middleware
{
    public function execute(Request $request, Response $response)
    {
        dump('Executing middleware');die;
    }

}