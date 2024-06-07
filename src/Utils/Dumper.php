<?php

namespace Hk\Core\Utils;

class Dumper
{
    public static function dump(mixed $data): void
    {

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
}