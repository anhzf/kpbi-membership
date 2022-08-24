<?php

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum AcademicDegree: string
{
    use ArrayableEnum;

    case Bachelor = 'bachelor';
    case Master = 'master';
    case Doctor = 'doctor';
}
