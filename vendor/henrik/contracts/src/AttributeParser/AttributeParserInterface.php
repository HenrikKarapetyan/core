<?php

namespace Henrik\Contracts\AttributeParser;

use ReflectionClass;

interface AttributeParserInterface
{
    /**
     * @param object|null             $attributeClass
     * @param ReflectionClass<object> $reflectionClass
     *
     * @return void
     */
    public function parse(?object $attributeClass, ReflectionClass $reflectionClass): void;
}