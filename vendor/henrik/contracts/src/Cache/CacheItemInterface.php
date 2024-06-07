<?php

namespace Henrik\Contracts\Cache;

use Psr\Cache\CacheItemInterface as PsrCacheItemInterface;

interface CacheItemInterface extends PsrCacheItemInterface
{
    public function getExpiration(): ?int;
}