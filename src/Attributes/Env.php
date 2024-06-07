<?php

namespace Hk\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Env
{
    public function __construct(public string $name) {}
}