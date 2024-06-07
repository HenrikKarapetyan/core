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

        $className = $attributeClass::class;
        if ($this->attributesParserContainer->has($className)) {

            /** @var string $classNameFromContainer */
            $classNameFromContainer = $this->attributesParserContainer->get($className);
            /** @var AttributeParserInterface $parserInstance */
            $parserInstance = $this->dependencyInjector->get($classNameFromContainer);

            $parserInstance->parse($attributeClass, $reflectionClass);
        }
    }
}