<?php

namespace Henrik\Core\Commands;

use Henrik\Console\Attributes\AsCommand;
use Henrik\Console\Interfaces\CommandInterface;
use Henrik\Console\Interfaces\InputInterface;
use Henrik\Console\Interfaces\OutputInterface;
use Henrik\Contracts\Cache\CacheClearEvent;
use Henrik\Contracts\CoreEvents;
use Henrik\Contracts\EventDispatcherInterface;

/**
 * @SuppressWarnings(PHPMD)
 */
#[AsCommand('cache:clear', 'Cache clear command')]
readonly class CacheClearCommand implements CommandInterface
{
    public function __construct(private EventDispatcherInterface $cacheEventDispatcher) {}

    public function run(InputInterface $input, OutputInterface $output): mixed
    {
        $this->cacheEventDispatcher->dispatch(new CacheClearEvent(), CoreEvents::CACHE_DISPOSE_EVENT);

        return null;
    }
}