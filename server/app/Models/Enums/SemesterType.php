<?php

namespace App\Models\Enums;

use App\Concerns\ArrayableEnum;

enum SemesterType: string
{
    use ArrayableEnum;

    case ODD = 'odd';
    case EVEN = 'even';
}
