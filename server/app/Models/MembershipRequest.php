<?php

namespace App\Models;

use App\Models\Enums\MembershipRequestStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

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
class MembershipRequest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const STATUS_DEFAULT = MembershipRequestStatus::PENDING;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['media'];

    public function attachment(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('membership_requests'),
            set: fn (FileAdder $v) => $v->toMediaCollection('membership_requests')
        );
    }

    public function attachmentUrl(): Attribute
    {
        return Attribute::get(fn () => $this->attachment->getUrl());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('membership_requests')
            ->singleFile();
    }
}
