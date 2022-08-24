<?php

namespace App\Models\Enums;

use App\Concerns\ArrayableEnum;

enum CollegeType: string
{
    use ArrayableEnum;

    case Private = 'private';
    case State = 'state';
}
