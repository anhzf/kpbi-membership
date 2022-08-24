<?php

namespace App\Models\Enums;

use App\Concerns\ArrayableEnum;

enum MembershipRequestStatus: string
{
    use ArrayableEnum;

    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
