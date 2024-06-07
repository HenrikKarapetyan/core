<?php

use Henrik\Cache\Adapters\FileCachePool;
use Henrik\Contracts\AttributeParser\AttributesParserProcessorInterface;
use Henrik\Contracts\Enums\ServiceScope;
use Henrik\Contracts\Environment\EnvironmentInterface;
use Henrik\Contracts\Environment\EnvironmentParserInterface;
use Henrik\Contracts\EventDispatcherInterface;
use Henrik\Contracts\FunctionInvokerInterface;
use Henrik\Contracts\Http\RequestInterface;
use Henrik\Contracts\MethodInvokerInterface;
use Henrik\Contracts\Utils\MarkersInterface;
use Henrik\DI\Utils\FunctionInvoker;
use Henrik\DI\Utils\MethodInvoker;
use Henrik\Env\Environment;
use Henrik\Env\IniEnvironmentParser;
use Henrik\Events\EventDispatcher;
use Henrik\Http\Request;
use Henrik\View\Extension\AssetExtension;
use Henrik\View\Renderer;
use Hk\Core\AttributeParsers\AsEventListenerAttributeParser;
use Hk\Core\AttributeParsers\AttributesParserProcessor;
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
            'id'    => AssetExtension::class,
            'class' => AssetExtension::class,
            'args'  => [
                'basePath' => MarkersInterface::AS_SERVICE_PARAM_MARKER . 'assetsDir',
            ],
        ],
        [
            'id'     => Renderer::class,
            'class'  => Renderer::class,
            'params' => [
                'viewDirectory' => MarkersInterface::AS_SERVICE_PARAM_MARKER . 'viewDirectory',
            ],
        ],

        [
            'id'    => CacheItemPoolInterface::class,
            'class' => FileCachePool::class,
        ],

        [
            'id'    => EnvironmentParserInterface::class,
            'class' => IniEnvironmentParser::class,
        ],
        [
            'id'    => EnvironmentInterface::class,
            'class' => Environment::class,
        ],

    ],

    ServiceScope::PARAM->value => [
        RequestInterface::class => Request::createFromGlobals(),
    ],
];