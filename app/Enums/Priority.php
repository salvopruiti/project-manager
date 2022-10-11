<?php

namespace App\Enums;

class Priority extends Enum implements EnumInterface
{
    const LOWEST = 1;
    const LOWER = 2;
    const LOW = 3;
    const NORMAL = 4;
    const HIGH = 5;
    const HIGHER = 6;
    const HIGHEST = 7;
    const CRITICAL = 10;

    static $labels = [
        self::LOWEST => 'Minima',
        self::LOWER => 'Più Bassa',
        self::LOW => 'Bassa',
        self::NORMAL => 'Normale',
        self::HIGH => 'Alta',
        self::HIGHER => 'Più alta',
        self::HIGHEST => 'Altissima',
        self::CRITICAL => 'Massima',
    ];

    static function all(): array
    {
        return collect(parent::all())->sortKeysDesc()->toArray();
    }


}
