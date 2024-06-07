<?php

declare(strict_types=1);

namespace Henrik\Contracts;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

interface EventDispatcherInterface extends PsrEventDispatcherInterface
{
    /**
     * @param object      $event
     * @param string|null $eventName
     *
     * @return object
     */
    public function dispatch(object $event, ?string $eventName = null): object;

    /**
     * @param string|null $eventName
     *
     * @return array<string, array<mixed>>
     */
    public function getListeners(?string $eventName = null): array;

    /**
     * @param string                               $eventName
     * @param array<string, array<mixed>>|callable $listener
     *
     * @return int|null
     */
    public function getListenerPriority(string $eventName, array|callable $listener): ?int;

    /**
     * @param string|null $eventName
     *
     * @return bool
     */
    public function hasListeners(?string $eventName = null): bool;

    /**
     * @param string                               $eventName
     * @param array<string, array<mixed>>|callable $listener
     * @param int                                  $priority
     *
     * @return void
     */
    public function addListener(string $eventName, array|callable $listener, int $priority = 0): void;

    /**
     * @param string                               $eventName
     * @param array<string, array<mixed>>|callable $listener
     *
     * @return void
     */
    public function removeListener(string $eventName, array|callable $listener): void;

    /**
     * @param EventSubscriberInterface $subscriber
     *
     * @return void
     */
    public function addSubscriber(EventSubscriberInterface $subscriber): void;

    /**
     * @param EventSubscriberInterface $subscriber
     *
     * @return void
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber): void;
}