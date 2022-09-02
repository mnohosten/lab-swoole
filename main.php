<?php
require __DIR__ . '/vendor/autoload.php';

use App\HttpKernel;
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

$server = new Swoole\HTTP\Server("0.0.0.0", 9501);

$server->on("Start", function(Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$server->on("Request", function(Request $request, Response $response) {
    HttpKernel::run($request, $response);
});

$server->start();
