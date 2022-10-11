<?php

namespace App\Enums;

class Source extends Enum implements EnumInterface
{
    const MANUAL = 0;
    const EMAIL = 1;
    const PHONE = 2;

    static $labels = [
        self::MANUAL => 'Manuale',
        self::EMAIL => 'E-Mail',
        self::PHONE => 'Telefono'
    ];
}
