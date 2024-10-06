<?php

namespace App\Enums;

enum MaritalStatusEnum: string
{
    case single = 'single';
    case married = 'married';
    case divorced = 'divorced';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
