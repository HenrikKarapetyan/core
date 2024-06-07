<?php

namespace Henrik\Contracts;

abstract class BaseComponent implements ComponentInterface
{
    public function getServices(): array
    {
        return [];
    }
}