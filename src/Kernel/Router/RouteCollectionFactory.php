<?php
declare(strict_types=1);

namespace App\Kernel\Router;

use App\Kernel\Attribute\Controller;
use App\Kernel\Attribute\Method\Method;
use App\Kernel\Attribute\Middleware\Middleware;
use Laminas\File\ClassFileLocator;
use Laminas\File\PhpClassFile;

class RouteCollectionFactory
{
    /**
     * @param string $path
     * @return array | RouteHandlerPayload[]
     * @throws \ReflectionException
     */
    public static function create(string $path): array
    {
        $collection = [];
        $locator = new ClassFileLocator($path);
        foreach ($locator as $file) {
            /** @var  PhpClassFile $file */
            foreach ($file->getClasses() as $class) {
                $reflection = new \ReflectionClass($class);
                $controllerMiddlewares = [];
                $isController = false;
                $controllerAttribute = null;
                foreach ($reflection->getAttributes() as $attribute) {
                    $attributeInstance = $attribute->newInstance();
                    if ($attributeInstance instanceof Middleware) {
                        $controllerMiddlewares[] = $attributeInstance;
                    }
                    if($attributeInstance instanceof Controller) {
                        $isController = true;
                        $controllerAttribute = $attributeInstance;
                    }
                }
                if($isController) {
                    $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
                    foreach ($methods as $method) {
                        $methodKey = sprintf('%s::%s', $method->class, $method->name);
                        $methodMiddlewares = [];
                        foreach ($method->getAttributes() as $methodAttribute) {
                            $methodInstance = $methodAttribute->newInstance();
                            if($methodInstance instanceof Method) {
                                $collection[$methodKey] = new RouteHandlerPayload(
                                    $methodInstance->method,
                                    sprintf('%s%s', $controllerAttribute->prefix, $methodInstance->path),
                                    $method,
                                    [
                                        'controller' => $controllerMiddlewares,
                                        'method' => &$methodMiddlewares,
                                    ]
                                );
                            }
                            if($methodInstance instanceof Middleware) {
                                $methodMiddlewares[] = $methodInstance;
                            }
                        }
                    }
                }
            }
        }
        return $collection;
    }
}