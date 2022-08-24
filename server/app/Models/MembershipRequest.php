<?php

namespace App\Models;

use App\Models\Enums\MembershipRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipRequest extends Model
{
    use HasFactory;

    const STATUS_DEFAULT = MembershipRequestStatus::Pending;
}
