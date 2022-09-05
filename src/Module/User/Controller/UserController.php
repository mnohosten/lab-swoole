<?php
declare(strict_types=1);

namespace App\Module\User\Controller;

use App\Kernel\Attribute\Controller;
use App\Kernel\Attribute\Method;
use App\Kernel\Router\ResourceInput;
use Nette\Database\Explorer;
use Swoole\Http\Request;
use Swoole\Http\Response;

#[Controller('/user')]
class UserController
{

    public function __construct(
        private readonly Explorer $explorer
    )
    {
    }

    #[Method\Get()]
    public function list(ResourceInput $input): void
    {
        $input->response->header("Content-Type", "application/json");
        $input->response->end(json_encode([
            'ok' => true,
            'username' => 'email@martinkrizan.com',
            'planning_step' => iterator_to_array($this->explorer->table('planning_step')->limit(1)->fetch())
        ]));
            
    }
}