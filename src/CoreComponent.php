<?php

namespace Hk\Core;

use Henrik\Contracts\BaseComponent;
use Henrik\Contracts\ComponentInterfaces\AttributesAndParsersAwareInterface;
use Henrik\Contracts\ComponentInterfaces\EventSubscriberAwareInterface;
use Henrik\Contracts\EventDispatcherInterface;
use Henrik\DI\Attributes\AsFactory;
use Henrik\DI\Attributes\AsPrototype;
use Henrik\DI\Attributes\AsService;
use Henrik\DI\Attributes\AsSingleton;
use Henrik\DI\DIAttributesParser;
use Henrik\Events\Attributes\AsEventListener;
use Hk\App\Core\Subscribers\MatchedRouteSubscriber;
use Hk\Core\AttributeParsers\AsEventListenerAttributeParser;
use Hk\Core\AttributeParsers\ValueAttributeParser;
use Hk\Core\Attributes\Value;

class CoreComponent extends BaseComponent implements EventSubscriberAwareInterface, AttributesAndParsersAwareInterface
{
    public function getServices(): array
    {
        return require 'config/services.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getEventSubscribers(): array
    {
        return [
            EventDispatcherInterface::class => [MatchedRouteSubscriber::class],
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
}