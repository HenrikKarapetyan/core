<?php

namespace Hk\Core\AttributeParsers;

use Henrik\Contracts\AttributeParser\AttributeParserInterface;
use Henrik\Contracts\DependencyInjectorInterface;
use Henrik\Contracts\EventDispatcherInterface;
use Henrik\Events\Attributes\AsEventListener;
use Hk\Core\Exceptions\HandlerMethodsNotExistsException;
use ReflectionClass;
use ReflectionMethod;

readonly class AsEventListenerAttributeParser implements AttributeParserInterface
{
    public function __construct(private DependencyInjectorInterface $dependencyInjector) {}

    public function parse(?object $attributeClass, ReflectionClass $reflectionClass): void
    {
        /** @var ?AsEventListener $eventListenerAttr */
        $eventListenerAttr = $attributeClass;

        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $eventListenerAttr?->dispatcher ? $this->dependencyInjector->get($eventListenerAttr->dispatcher) : $this->dependencyInjector->get(EventDispatcherInterface::class);

        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

        if (count($methods) == 0) {
            throw new HandlerMethodsNotExistsException();
        }

        $handlerInstance = $this->dependencyInjector->get($reflectionClass->getName());

        if ($reflectionClass->hasMethod('__invoke')) {

            $eventDispatcher->addListener((string) $eventListenerAttr?->event, [$handlerInstance, '__invoke'], $eventListenerAttr->priority ?? 0);

            return;
        }

        if ($eventListenerAttr) {
            $eventDispatcher->addListener((string) $eventListenerAttr->event, [$handlerInstance, $eventListenerAttr->method], $eventListenerAttr->priority ?? 0);
        }
    }
}