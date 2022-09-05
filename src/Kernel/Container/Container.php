<?php
declare(strict_types=1);

namespace App\Kernel\Container;

use Closure;
use ReflectionClass;
use RuntimeException;

class Container
{
    private static array $deps = [];

    public static function add(string $dependency, Closure $callback): void
    {
        if (isset(self::$deps[$dependency])) {
            throw new RuntimeException(
                "Dependency `$dependency` already exists in container."
            );
        }
        self::$deps[$dependency] = [
            'init' => false,
            'instance' => $callback,
        ];
    }

    public static function get(string $dependency): mixed
    {
        if (!isset(self::$deps[$dependency])) {
            throw new RuntimeException(
                "Dependency `$dependency` does not exists in container."
            );
        }
        if (!self::$deps[$dependency]['init']) {
            self::$deps[$dependency]['instance'] = call_user_func(self::$deps[$dependency]['instance']);
            self::$deps[$dependency]['init'] = true;
        }
        return self::$deps[$dependency]['instance'];
    }

    public static function has(string $dependency)
    {
        return isset(self::$deps[$dependency]);
    }

    public static function getShared(string $dependency, Closure $closure)
    {
        if(self::has($dependency)) {
            return self::shared($dependency);
        }
        self::add($dependency, $closure);
        return self::shared($dependency);
    }

    public static function shared(string $dependency): mixed
    {
        if (self::has($dependency)) {
            return self::get($dependency);
        }
        $args = [];
        $reflectionClass = new ReflectionClass($dependency);
        foreach ($reflectionClass->getConstructor()?->getParameters() ?? [] as $a) {
            if (!$a->hasType()) {
                throw new RuntimeException(
                    "Dynamical dependencies should created only from objects. " .
                    "Check your `$dependency` constructor definition."
                );
            }
            $args[$a->getName()] = Container::shared($a->getType()->getName());
        }
        $instance = $reflectionClass->newInstanceArgs($args);
        self::$deps[$dependency] = [
            'init' => true,
            'instance' => $instance,
        ];
        return $instance;
    }
}
