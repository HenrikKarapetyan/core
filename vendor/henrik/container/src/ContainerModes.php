<?php

declare(strict_types=1);

namespace Henrik\Container;

/**
 * Class ContainerModes.
 */
enum ContainerModes: int
{
    case SINGLE_VALUE_MODE   = 1;
    case MULTIPLE_VALUE_MODE = 2;
}