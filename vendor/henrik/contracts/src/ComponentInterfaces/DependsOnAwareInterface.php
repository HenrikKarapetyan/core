<?php

namespace Henrik\Contracts\ComponentInterfaces;

interface DependsOnAwareInterface
{
    /**
     * @return array<string>
     */
    public function dependsOn(): array;
}