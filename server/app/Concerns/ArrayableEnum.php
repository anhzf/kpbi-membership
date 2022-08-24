<?php

namespace App\Concerns;

trait ArrayableEnum
{
    public static function toArray()
    {
        return array_map(fn (self $el) => $el->value, self::cases());
    }
}
