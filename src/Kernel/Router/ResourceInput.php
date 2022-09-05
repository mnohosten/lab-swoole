<?php
declare(strict_types=1);

namespace App\Kernel\Router;

use Swoole\Http\Request;
use Swoole\Http\Response;

class ResourceInput
{
    public function __construct(
        public readonly Request $request,
        public readonly Response $response,
        public readonly array $vars
    )
    {
    }
}