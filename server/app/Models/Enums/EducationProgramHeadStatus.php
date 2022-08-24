<?php

namespace App\Models\Enums;

use App\Concerns\ArrayableEnum;

enum EducationProgramHeadStatus: string
{
    use ArrayableEnum;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
