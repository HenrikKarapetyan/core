<?php

namespace Henrik\Contracts;

interface MethodInvokerInterface
{
    /**
     * @param object                   $obj
     * @param string                   $method
     * @param array<int|string, mixed> $args
     *
     * @return mixed
     */
    public function invoke(object $obj, string $method, array $args = []): mixed;
}