<?php

namespace Hk\Core;

use Henrik\Container\Exceptions\KeyAlreadyExistsException;
use Henrik\Container\Exceptions\KeyNotFoundException;
use henrik\Container\Exceptions\UndefinedModeException;
use Henrik\Contracts\AttributeParser\AttributesParserProcessorInterface;
use Henrik\Contracts\ComponentInterface;
use Henrik\Contracts\ComponentInterfaces\AttributesAndParsersAwareInterface;
use Henrik\Contracts\ComponentInterfaces\ControllerAwareInterface;
use Henrik\Contracts\ComponentInterfaces\EventSubscriberAwareInterface;
use Henrik\Contracts\ComponentInterfaces\OnBootstrapAwareInterface;
use Henrik\Contracts\ComponentInterfaces\TemplateAwareInterface;
use Henrik\Contracts\DependencyInjectorInterface;
use Henrik\Contracts\Enums\InjectorModes;
use Henrik\Contracts\Environment\EnvironmentInterface;
use Henrik\Contracts\EventDispatcherInterface;
use Henrik\Contracts\EventSubscriberInterface;
use Henrik\DI\DependencyInjector;
use Henrik\DI\Exceptions\ClassNotFoundException;
use Henrik\DI\Exceptions\ServiceNotFoundException;
use Henrik\DI\Exceptions\UnknownConfigurationException;
use Henrik\DI\Exceptions\UnknownScopeException;
use InvalidArgumentException;

class Kernel
{
    public const DEFAULT_ENV = 'dev';

    private DependencyInjectorInterface $dependencyInjector;

    /**
     * @var array<string, array<string, string>>
     */
    private array $onBootstrapEvents = [];

    /**
     * @var string[]
     */
    private array $templatePaths = [];

    private array $controllersPath = [];

    /**
     * @param array<string, array<string, int|string>>|string $services
     * @param array<string>                                   $components
     *
     * @throws ClassNotFoundException
     * @throws KeyAlreadyExistsException
     * @throws KeyNotFoundException
     * @throws ServiceNotFoundException
     * @throws UndefinedModeException
     * @throws UnknownConfigurationException
     * @throws UnknownScopeException
     */
    public function __construct(array $services, array $components)
    {
        $this->dependencyInjector = DependencyInjector::instance();
        $this->dependencyInjector->setMode(InjectorModes::AUTO_REGISTER);
        $this->dependencyInjector->load($services);

        $this->loadEnvironments();
        $this->loadComponents($components);
    }

    /**
     * @param array<string> $components
     *
     * @throws ClassNotFoundException
     * @throws KeyAlreadyExistsException
     * @throws KeyNotFoundException
     * @throws ServiceNotFoundException
     * @throws UndefinedModeException
     * @throws UnknownConfigurationException
     * @throws UnknownScopeException
     *
     * @return void
     */
    public function loadComponents(array $components): void
    {
        if (!isset($components[CoreComponent::class])) {
            $components[] = CoreComponent::class;
        }

        $eventSubscribers = [];
        $attrParsers      = [];
        $services         = [];
        $templatePaths    = [];
        $controllerPaths  = [];

        foreach ($components as $component) {

            /** @var ComponentInterface $componentInstance */
            $componentInstance = new $component();
            $services          = array_merge_recursive($services, $componentInstance->getServices());

            if ($componentInstance instanceof EventSubscriberAwareInterface) {

                $eventSubscribers = array_merge_recursive($eventSubscribers, $componentInstance->getEventSubscribers());
            }

            if ($componentInstance instanceof AttributesAndParsersAwareInterface) {
                $attrParsers = array_merge_recursive($attrParsers, $componentInstance->getAttributesAndParsers());
            }

            if ($componentInstance instanceof TemplateAwareInterface) {
                $templatePaths[] = $componentInstance->getTemplatesPath();
            }

            if ($componentInstance instanceof ControllerAwareInterface) {
                $controllerPaths[] = $componentInstance->getControllersPath();
            }

            if ($componentInstance instanceof OnBootstrapAwareInterface) {
                $this->onBootstrapEvents = array_merge_recursive($this->onBootstrapEvents, $componentInstance->onBootstrapDispatchEvents());
            }

        }

        $this->dependencyInjector->load($services);

        $this->loadComponentsEventSubscribers($eventSubscribers);
        $this->loadComponentsAttributesAndParsers($attrParsers);
        $this->setTemplatesPath($templatePaths);
        $this->loadControllersByPath($controllerPaths);
    }

    public function getProjectDir(): string
    {
        return dirname($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../');
    }

    public function getOutputDirectory(): string
    {
        $env = self::DEFAULT_ENV;

        if ($this->dependencyInjector->has(EnvironmentInterface::class)) {
            $envObject = $this->dependencyInjector->get(EnvironmentInterface::class);
            $env       = $envObject->get('app')['env']; // @phpstan-ignore-line
        }

        // for example /var/dev/log
        return $this->getProjectDir() . 'var' . DIRECTORY_SEPARATOR . $env . DIRECTORY_SEPARATOR;
    }

    public function getConfigDirectory(): string
    {
        return dirname($this->getProjectDir() . '/../config/');
    }

    /**
     * @param array<string, array<string>> $eventSubscribers
     *
     * @throws ServiceNotFoundException
     * @throws UnknownScopeException
     * @throws ClassNotFoundException
     * @throws KeyAlreadyExistsException
     * @throws KeyNotFoundException
     *
     * @return void
     */
    private function loadComponentsEventSubscribers(array $eventSubscribers): void
    {

        foreach ($eventSubscribers as $eventDispatcherDefinitionId => $eventSubscriberItems) {

            if ($this->dependencyInjector->has($eventDispatcherDefinitionId)) {
                /** @var EventDispatcherInterface $eventDispatcher */
                $eventDispatcher = $this->dependencyInjector->get($eventDispatcherDefinitionId);

                if (!is_array($eventSubscriberItems)) {
                    throw new InvalidArgumentException(sprintf('Given value must be array `%s` given!', gettype($eventSubscriberItems)));
                }

                foreach ($eventSubscriberItems as $eventSubscriber) {
                    /** @var EventSubscriberInterface $subscriber */
                    $subscriber = $this->dependencyInjector->get($eventSubscriber);
                    $eventDispatcher->addSubscriber($subscriber);
                }

            }
        }
    }

    /**
     * @param array<string> $attrParsers
     *
     * @throws ServiceNotFoundException
     * @throws UnknownScopeException
     * @throws ClassNotFoundException
     * @throws KeyAlreadyExistsException
     * @throws KeyNotFoundException
     *
     * @return void
     */
    private function loadComponentsAttributesAndParsers(array $attrParsers): void
    {
        if ($this->dependencyInjector->has(AttributesParserProcessorInterface::class)) {
            /** @var AttributesParserProcessorInterface $attributeParserProcessor */
            $attributeParserProcessor = $this->dependencyInjector->get(AttributesParserProcessorInterface::class);

            foreach ($attrParsers as $attributeClass => $parserClass) {

                $attributeParserProcessor->addParser($attributeClass, $parserClass);
            }
        }
    }

    /**
     * @param array<string> $templatePaths
     *
     * @return void
     */
    private function setTemplatesPath(array $templatePaths): void
    {
        $this->templatePaths = array_merge_recursive($templatePaths, $this->templatePaths);
    }

    /**
     * @param array<string> $controllerPaths
     *
     * @return void
     */
    private function loadControllersByPath(array $controllerPaths): void
    {
        $this->controllersPath = array_merge_recursive($controllerPaths, $this->controllersPath);
    }

    /**
     * @throws UnknownScopeException
     * @throws ServiceNotFoundException
     * @throws KeyNotFoundException
     * @throws ClassNotFoundException
     * @throws KeyAlreadyExistsException
     */
    private function loadEnvironments(): void
    {
        $env = self::DEFAULT_ENV;

        if ($this->dependencyInjector->has(EnvironmentInterface::class)) {
            /** @var EnvironmentInterface $envObject */
            $envObject = $this->dependencyInjector->get(EnvironmentInterface::class);
            $envObject->load($this->getConfigDirectory() . 'env.ini');

            if (isset($envObject->get('app')['env'])) {// @phpstan-ignore-line
                $env = $envObject->get('app')['env'];
            }
            $envObject->load($this->getConfigDirectory() . $env . 'env.ini');
        }
    }
}