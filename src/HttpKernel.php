<?php
declare(strict_types=1);

namespace App;

use Swoole\Http\Request;

class HttpKernel
{
    public static function run(Request $request, \Swoole\Http\Response $response): void
    {
      $response->header("Content-Type", "text/plain");
      $response->end("Hello Vitezslav Kis!!!\n");
    }
}
