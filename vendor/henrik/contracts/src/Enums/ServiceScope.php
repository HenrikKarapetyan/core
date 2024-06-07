<?php

declare(strict_types=1);

namespace Henrik\Contracts\Enums;

enum ServiceScope: string
{
    /**
     * DI singletons.
     */
    case SINGLETON = 'SINGLETON';

    /**
     * DI prototypes.
     */
    case PROTOTYPE = 'PROTOTYPE';

    /**
     * DI factories.
     */
    case FACTORY = 'FACTORY';
    /**
     * DI parameters.
     */
    case PARAM = 'PARAM';

    /**
     * DI Aliases.
     */
    case ALIAS = 'ALIAS';
}