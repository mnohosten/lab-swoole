<?php
declare(strict_types=1);

namespace App;

use App\Factory\ContainerFactory;
use App\Kernel\Container\Container;
use App\Kernel\Router\DispatcherFactory;
use App\Kernel\Router\ResourceInput;
use App\Kernel\Router\RouteHandlerPayload;
use FastRoute\Dispatcher;
use Swoole\Http\Request;
use Swoole\Http\Response;

class HttpKernel
{
    public static function run(Request $request, Response $response): void
    {
        (new ContainerFactory())->create();
        /** @var Dispatcher $dispatcher */
        $dispatcher = Container::getShared(Dispatcher::class, function () {
            return DispatcherFactory::create(__DIR__ . '/Module');
        });
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            parse_url($request->server['request_uri'], PHP_URL_PATH)
        );
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $response->header("Content-Type", "application/json");
                $response->status(404);
                $response->end(json_encode([
                    'ok' => false,
                    'message' => 'Resource not found.'
                ]));
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $response->header("Content-Type", "application/json");
                $response->status(405);
                $response->end(json_encode([
                    'ok' => false,
                    'message' => 'Method not allowed.'
                ]));
                break;
            case Dispatcher::FOUND:
                /** @var RouteHandlerPayload $handlerPayload */
                $handlerPayload = $routeInfo[1];
                $controller = Container::shared($handlerPayload->reflectionMethod->class);
                call_user_func_array(
                    [$controller, $handlerPayload->reflectionMethod->name],
                    [new ResourceInput($request,$response, $routeInfo[2])]
                );
                break;
        }

    }
}
