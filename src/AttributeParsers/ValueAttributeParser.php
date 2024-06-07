<?php

namespace Hk\Core\AttributeParsers;

use Henrik\Contracts\AttributeParser\AttributeParserInterface;
use Henrik\Contracts\DependencyInjectorInterface;
use Hk\Core\Attributes\Value;
use ReflectionClass;
use ReflectionMethod;

/**
 * @SuppressWarnings(PHPMD)
 */
class ValueAttributeParser implements AttributeParserInterface
{
    //    public function __construct(private DependencyInjectorInterface $dependencyInjector) {}

    public function parse(?object $attributeClass, ReflectionClass $reflectionClass): void
    {
        //        /** @var ?Value $valueAttr */
        //        $valueAttr = $attributeClass;
        //
        //        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
    }
}