<?php

namespace App\Enums;

abstract class Enum implements EnumInterface
{
    static $labels = [];
    static $sort = true;

    static function getName(int $value) : string
    {
        return __(static::$labels[$value] ?? $value);
    }

    static function all(): array
    {
        $ref = new \ReflectionClass(static::class);

        return collect($ref->getConstants())->mapWithKeys(function($value) {

            return [
                $value => static::getName($value)
            ];

        })->when(static::$sort, function ($data) {

            return $data->sort();

        })->toArray();

    }
}
