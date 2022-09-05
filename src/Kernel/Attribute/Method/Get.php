<?php
declare(strict_types=1);

namespace App\Kernel\Attribute\Method;

#[\Attribute]
class Get extends Method
{
    public function __construct(
        string $path = ''
    )
    {
        $this->path = $path;
        $this->method = 'GET';
    }
}