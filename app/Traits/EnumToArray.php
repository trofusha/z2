<?php

namespace App\Traits;

trait EnumToArray
{

    /**
     * @return string[]
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return mixed[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array<int, mixed>
     */
    public static function array(): array
    {
        $values = self::values();

        return empty($values) ? self::names() : array_combine($values, self::names());
    }
}
