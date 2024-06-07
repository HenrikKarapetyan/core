<?php

namespace Hk\Core;

use Henrik\Command\ConsoleComponent;
use Henrik\Contracts\BaseComponent;
use Henrik\Contracts\ComponentInterfaces\AttributesAndParsersAwareInterface;
use Henrik\Contracts\ComponentInterfaces\DependsOnAwareInterface;
use Henrik\DI\Attributes\AsFactory;
use Henrik\DI\Attributes\AsPrototype;
use Henrik\DI\Attributes\AsService;
use Henrik\DI\Attributes\AsSingleton;
use Henrik\DI\DIAttributesParser;
use Henrik\Events\Attributes\AsEventListener;
use Henrik\Log\LoggerComponent;
use Hk\Core\AttributeParsers\AsEventListenerAttributeParser;
use Hk\Core\AttributeParsers\ValueAttributeParser;
use Hk\Core\Attributes\Value;

class CoreComponent extends BaseComponent implements AttributesAndParsersAwareInterface, DependsOnAwareInterface
{
    public function getServices(): array
    {
        return require 'config/services.php';
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

    public function dependsOn(): array
    {
        return [
            LoggerComponent::class,
            ConsoleComponent::class,
        ];

    }
}