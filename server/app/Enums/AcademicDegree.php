<?php

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum AcademicDegree: string
{
    use ArrayableEnum;

    case BACHELOR = 'bachelor';
    case MASTER = 'master';
    case DOCTOR = 'doctor';
}
