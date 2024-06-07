<?php

namespace Henrik\Contracts\AttributeParser;

use ReflectionClass;

interface AttributesParserProcessorInterface
{
    public function addParser(string $attributeClass, string $parserClass): void;

    /**
     * @param object                  $attributeClass
     * @param ReflectionClass<object> $reflectionClass
     *
     * @return void
     */
    public function process(object $attributeClass, ReflectionClass $reflectionClass): void;
}