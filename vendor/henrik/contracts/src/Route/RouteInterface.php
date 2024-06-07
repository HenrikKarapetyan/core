<?php

declare(strict_types=1);

namespace Henrik\Contracts\Route;

interface RouteInterface
{
    public function getRouteOptions(): RouteOptionInterface;

    public function setRouteOptions(RouteOptionInterface $routeOptions): void;

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array;

    /**
     * @param string $param
     * @param mixed  $value
     */
    public function addParam(string $param, mixed $value): void;

    /**
     * @param array<string, mixed> $params
     *
     * @return void
     */
    public function setParams(array $params): void;
}