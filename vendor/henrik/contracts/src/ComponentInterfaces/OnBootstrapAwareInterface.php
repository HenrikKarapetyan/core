<?php

namespace Henrik\Contracts\ComponentInterfaces;

use Henrik\Contracts\ComponentInterface;

interface OnBootstrapAwareInterface
{
    /**
     * Example.
     *
     * [
     *      EventDispatcherInterface::class => [
     *              '#definitionId' => CoreEvents::HTTP_REQUEST_EVENTS
     *      ]
     * ]
     *
     * Here EventDispatcherInterface::class is our default EventDispatcher definition id
     * it's of course we can set as custom event dispatcher definition id,
     * but the first we must register our new dispatcher if we don't want to use default definition id
     *
     * '#definitionId' =>  it's our service which we must register into services
     *
     * @see ComponentInterface::getServices();
     *
     * CoreEvents::HTTP_REQUEST_EVENTS => it's our event name
     *
     * This method we must call after services registration
     *
     * @return array<string, array<string, string>>
     */
    public function onBootstrapDispatchEvents(): array;
}