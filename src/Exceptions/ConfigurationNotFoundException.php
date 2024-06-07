<?php

namespace Hk\Core\Exceptions;

use Throwable;

class ConfigurationNotFoundException extends CoreException
{
    public function __construct(string $file, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('The configuration file `%s` does not exists!', $file), $code, $previous);
    }
}