<?php

declare(strict_types=1);

namespace Henrik\Contracts\Environment;

use ArrayAccess;

/**
 * @extends  ArrayAccess<mixed, mixed>
 */
interface EnvironmentInterface extends ArrayAccess
{
    public function get(string $id, mixed $default = null): mixed;

    /**
     * @param string $file
     */
    public function load(string $file): void;

    public function printData(): void;
}