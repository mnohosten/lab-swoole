<?php
declare(strict_types=1);

namespace App\Kernel\Attribute\Middleware;
use Swoole\Http\Request;
use Swoole\Http\Response;

#[\Attribute]
abstract class Middleware
{
    abstract public function execute(Request $request, Response $response);
}