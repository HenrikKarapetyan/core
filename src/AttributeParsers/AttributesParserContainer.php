<?php

namespace Henrik\Core\AttributeParsers;

use Henrik\Container\Container;
use Henrik\Container\ContainerModes;
use Henrik\Container\Exceptions\UndefinedModeException;

class AttributesParserContainer extends Container
{
    /**
     * @throws UndefinedModeException
     */
    public function __construct()
    {
        $this->changeMode(ContainerModes::SINGLE_VALUE_MODE);
    }
}