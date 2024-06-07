<?php

namespace Henrik\Contracts\Enums;

enum ServiceRegisterTypes
{
    case IGNORE_IF_EXISTS;
    case REPLACE_IF_EXISTS;
    case THROW_ERROR_IF_EXISTS;

}