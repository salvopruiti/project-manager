<?php

namespace App\Enums;

interface EnumInterface
{
    public static function getName(int $value) : string;

    /** @return array<int, string> */
    public static function all() : array;
}
