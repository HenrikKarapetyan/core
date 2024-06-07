<?php

declare(strict_types=1);

namespace Henrik\Contracts\Enums;

enum InjectorModes: string
{
    case AUTO_REGISTER = 'AUTO_REGISTER';

    case CONFIG_FILE = 'CONFIG_FILE';
}