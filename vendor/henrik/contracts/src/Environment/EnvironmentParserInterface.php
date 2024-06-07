<?php

declare(strict_types=1);

namespace Henrik\Contracts\Environment;

/**
 * Interface EnvironmentParserInterface.
 */
interface EnvironmentParserInterface
{
    /**
     * @param string $file
     *
     * @return array<string, mixed>
     */
    public function parse(string $file): array;
}