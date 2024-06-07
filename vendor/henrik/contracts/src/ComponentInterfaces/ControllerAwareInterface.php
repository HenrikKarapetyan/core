<?php

namespace Henrik\Contracts\ComponentInterfaces;

interface ControllerAwareInterface
{
    public function getControllersPath(): string;
}