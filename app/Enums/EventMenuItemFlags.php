<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EventMenuItemFlags extends Enum
{
    const SELF_DEFAULT_MENU = 1;
    const SAME_STORE_MENU = 2;
    const EDIT_STORE_MENU = 3;

    public static function toKeyedSelectArray()
    {
        return json_decode(json_encode(static::toSelectArray()));
    }

    public static function toKeyedArray()
    {
        $array = self::toArray();
        $selectArray = [];

        foreach ($array as $key => $value) {
            array_push($selectArray, [
                'value' => $value,
                'key' => $key,
                'label' => static::getDescription($value),
            ]);
        }

        return $selectArray;
    }
}
