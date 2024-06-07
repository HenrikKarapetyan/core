<?php

namespace Henrik\Contracts\Route;

use Henrik\Contracts\HandlerTypesEnum;

interface RouteOptionInterface
{
    /**
     * @return array<string>|string
     */
    public function getMethod(): array|string;

    /**
     * @param array<string>|string $method
     *
     * @return self
     */
    public function setMethod(array|string $method): self;

    public function getHandler(): callable|string;

    public function setHandler(callable|string $handler): self;

    /**
     * @return array<string>
     */
    public function getMiddlewares(): array;

    /**
     * @param array<string> $middlewares
     *
     * @return self
     */
    public function setMiddlewares(array $middlewares): self;

    public function getHandlerType(): HandlerTypesEnum;

    public function setHandlerType(HandlerTypesEnum $handlerType): self;
}