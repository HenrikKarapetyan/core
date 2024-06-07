<?php

namespace Henrik\Contracts;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

interface ServerRequestFromGlobalsInterface
{
    public function getUriFromGlobals(): UriInterface;

    public function getServerRequest(): ServerRequestInterface;

    /**
     * @param array<string, mixed> $files
     *
     * @return array<mixed>
     */
    public function normalizeFiles(array $files): array;
}