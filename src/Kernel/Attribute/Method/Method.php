<?php
declare(strict_types=1);

namespace App\Kernel\Attribute\Method;

#[\Attribute]
abstract class Method
{
    public string $method;
    public string $path;
}