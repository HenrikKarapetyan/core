<?php

namespace Henrik\Contracts;

use Closure;

interface FunctionInvokerInterface
{
    /**
     * @param Closure                  $func
     * @param array<int|string, mixed> $args
     *
     * @return mixed
     */
    public function invoke(Closure $func, array $args = []): mixed;
}