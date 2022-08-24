<?php

namespace App\Models\Enums;

use App\Concerns\ArrayableEnum;

enum CollegeType: string
{
    use ArrayableEnum;

    case PRIVATE = 'private';
    case STATE = 'state';
}
