<?php

namespace Henrik\Contracts\ComponentInterfaces;

interface AttributesAndParsersAwareInterface
{
    /**
     * @return array<string, string>
     */
    public function getAttributesAndParsers(): array;
}