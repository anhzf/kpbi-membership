<?php

namespace App\Models;

use App\Models\Enums\MembershipRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $membership_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $requested_date
 * @property \App\Models\Enums\MembershipRequestStatus $status
 * @property int|null $authorized_by_id
 * @property \Illuminate\Support\Carbon|null $authorized_at
 * @property \Illuminate\Support\Carbon|null $valid_until
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Relationships
 * @property User $user
 * @property User|null $authorized_by
 */
class MembershipRequest extends Model
{
    use HasFactory;

    const STATUS_DEFAULT = MembershipRequestStatus::PENDING;
}
