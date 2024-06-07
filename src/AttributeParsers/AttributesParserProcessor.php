<?php

namespace Hk\Core\AttributeParsers;

use Henrik\Container\Exceptions\KeyAlreadyExistsException;
use Henrik\Contracts\AttributeParser\AttributeParserInterface;
use Henrik\Contracts\AttributeParser\AttributesParserProcessorInterface;
use Henrik\Contracts\DependencyInjectorInterface;
use ReflectionClass;

class AttributesParserProcessor implements AttributesParserProcessorInterface
{
    private AttributesParserContainer $attributesParserContainer;

    public function __construct(private readonly DependencyInjectorInterface $dependencyInjector)
    {
        $this->attributesParserContainer = new AttributesParserContainer();
    }

    /**
     * @param string $attributeClass
     * @param string $parserClass
     *
     * @throws KeyAlreadyExistsException
     */
    public function addParser(string $attributeClass, string $parserClass): void
    {
        $this->attributesParserContainer->set($attributeClass, $parserClass);
    }

    public function process(object $attributeClass, ReflectionClass $reflectionClass): void
    {

        if ($this->attributesParserContainer->has($attributeClass::class)) {

            /** @var AttributeParserInterface $parserInstance */
            $parserInstance = $this->dependencyInjector->get($this->attributesParserContainer->get($attributeClass::class));

            $parserInstance->parse($attributeClass, $reflectionClass);
        }
    }
}