<?php
declare(strict_types=1);

namespace App\Kernel\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Controller
{
    public function __construct(
        public string $prefix = ''
    )
    {
    }
}
