<?php

namespace App\Models\Enums;

use App\Concerns\ArrayableEnum;

enum UserRole: string
{
    use ArrayableEnum;

    case ADMIN = 'admin';
    case SECRETARY = 'secretary';
    case TREASURER = 'treasurer';
}
