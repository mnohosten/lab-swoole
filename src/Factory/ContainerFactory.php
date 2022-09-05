<?php
declare(strict_types=1);

namespace App\Factory;

use App\Kernel\Container\Container;
use Nette\Caching\Storages\MemoryStorage;
use Nette\Database\Connection;
use Nette\Database\Explorer;
use Nette\Database\Structure;

class ContainerFactory
{
    public function create(): void
    {
        if(!Container::has(Connection::class)) {
            Container::add(Connection::class, fn() => new Connection(
                'mysql:host=mysql;port=3306;dbname=routisto',
                'root',
                'root'
            ));
        }
        if(!Container::has(Explorer::class)) {
            Container::add(Explorer::class, fn() => new Explorer(
                    $this->getConnection(),
                    new Structure($this->getConnection(), new MemoryStorage())
                )
            );
        }
    }

    public function getConnection(): Connection
    {
        return Container::get(Connection::class);
    }
}
