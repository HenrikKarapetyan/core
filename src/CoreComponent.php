<?php

namespace Henrik\Core;

use Henrik\Cache\Adapters\FileCachePool;
use Henrik\Contracts\AttributeParser\AttributesParserProcessorInterface;
use Henrik\Contracts\BaseComponent;
use Henrik\Contracts\ComponentInterfaces\OnAttributesAndParsersAwareInterface;
use Henrik\Contracts\ComponentInterfaces\OnCommandAwareInterface;
use Henrik\Contracts\Enums\ServiceScope;
use Henrik\Contracts\EventDispatcherInterface;
use Henrik\Contracts\FunctionInvokerInterface;
use Henrik\Contracts\MethodInvokerInterface;
use Henrik\Core\AttributeParsers\AsEventListenerAttributeParser;
use Henrik\Core\AttributeParsers\AttributesParserProcessor;
use Henrik\Core\AttributeParsers\ValueAttributeParser;
use Henrik\Core\Attributes\Value;
use Henrik\DI\Attributes\AsFactory;
use Henrik\DI\Attributes\AsPrototype;
use Henrik\DI\Attributes\AsService;
use Henrik\DI\Attributes\AsSingleton;
use Henrik\DI\DIAttributesParser;
use Henrik\DI\Utils\FunctionInvoker;
use Henrik\DI\Utils\MethodInvoker;
use Henrik\Events\Attributes\AsEventListener;
use Henrik\Events\EventDispatcher;
use Psr\Cache\CacheItemPoolInterface;

class CoreComponent extends BaseComponent implements OnAttributesAndParsersAwareInterface, OnCommandAwareInterface
{
    public function getServices(): array
    {
        return [
            ServiceScope::SINGLETON->value => [
                [
                    'id'    => FunctionInvokerInterface::class,
                    'class' => FunctionInvoker::class,
                ],
                [
                    'id'    => MethodInvokerInterface::class,
                    'class' => MethodInvoker::class,
                ],
                [
                    'id'    => EventDispatcherInterface::class,
                    'class' => EventDispatcher::class,
                ],
                [
                    'id'    => AttributesParserProcessorInterface::class,
                    'class' => AttributesParserProcessor::class,
                ],
                [
                    'id'    => AsEventListenerAttributeParser::class,
                    'class' => AsEventListenerAttributeParser::class,
                ],
                [
                    'id'    => CacheItemPoolInterface::class,
                    'class' => FileCachePool::class,
                ],
            ],

        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributesAndParsers(): array
    {
        return [
            AsEventListener::class => AsEventListenerAttributeParser::class,
            AsService::class       => DIAttributesParser::class,
            AsSingleton::class     => DIAttributesParser::class,
            AsPrototype::class     => DIAttributesParser::class,
            AsFactory::class       => DIAttributesParser::class,
            Value::class           => ValueAttributeParser::class,
        ];
    }

    public function getCommandsPath(): string
    {
        return __DIR__ . '/Commands';
    }
}