<?php

declare(strict_types=1);

namespace Henrik\Contracts;

interface ComponentInterface
{
    /**
     * @return array<string, array<mixed>> $services
     */
    public function getServices(): array;
}