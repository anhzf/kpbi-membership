<?php

namespace App\Models\Enums;

use App\Concerns\ArrayableEnum;

enum MembershipRequestStatus: string
{
    use ArrayableEnum;

    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
