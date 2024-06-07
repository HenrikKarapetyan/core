<?php

namespace Henrik\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
class Autowire {}