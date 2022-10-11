<?php

namespace App\Enums;

class Status extends Enum implements EnumInterface
{
    const OPENED = 0;
    const IN_PROGRESS = 1;
    const RESOLVED = 2;
    const CLOSED = 3;
    const ARCHIVED = 4;

    static $labels = [
        self::OPENED => 'Aperto',
        self::IN_PROGRESS => 'In Lavorazione',
        self::RESOLVED => 'Risolto',
        self::CLOSED => 'Chiuso',
        self::ARCHIVED => 'Archiviato',
    ];

    static $sort = false;

}
