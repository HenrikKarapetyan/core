<?php

use Henrik\Cache\Adapters\FileCachePool;
use Henrik\Contracts\AttributeParser\AttributesParserProcessorInterface;
use Henrik\Contracts\Enums\ServiceScope;
use Henrik\Contracts\EventDispatcherInterface;
use Henrik\Contracts\FunctionInvokerInterface;
use Henrik\Contracts\Http\RequestInterface;
use Henrik\Contracts\MethodInvokerInterface;
use Henrik\Core\AttributeParsers\AsEventListenerAttributeParser;
use Henrik\Core\AttributeParsers\AttributesParserProcessor;
use Henrik\DI\Utils\FunctionInvoker;
use Henrik\DI\Utils\MethodInvoker;
use Henrik\Events\EventDispatcher;
use Henrik\Http\Request;
use Psr\Cache\CacheItemPoolInterface;

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

    ServiceScope::PARAM->value => [
        RequestInterface::class => Request::createFromGlobals(),
    ],
];