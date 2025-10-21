<?php

namespace App\Models;

use App\Models\Enums\MembershipRequestStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

/**
 * @property int $id
 * @property int $membership_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $requested_date
 * @property ?\Illuminate\Support\Carbon $transfer_at
 * @property \App\Models\Enums\MembershipRequestStatus $status
 * @property ?int $amount
 * @property ?int $authorized_by_id
 * @property ?\Illuminate\Support\Carbon $authorized_at
 * @property ?\Illuminate\Support\Carbon $valid_start
 * @property ?\Illuminate\Support\Carbon $valid_until
 * @property ?string $notes
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Accessors
 * @property string $attachment_url
 * @property boolean $isAccepted
 * Relationships
 * @property User $user
 * @property ?User $authorizedBy
 * @property Membership $membership
 */
class MembershipRequest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    const STATUS_DEFAULT = MembershipRequestStatus::PENDING;

    const OLD_YEARLY_MEMBERSHIP_FEE = 300_000;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => MembershipRequestStatus::class,
        'requested_date' => 'datetime',
        'authorized_at' => 'datetime',
        'transfer_at' => 'datetime',
        'valid_start' => 'datetime',
        'valid_until' => 'datetime',
    ];

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
            get: fn() => $this->getFirstMedia('membership_requests'),
            // set: fn (FileAdder $v) => $v->toMediaCollection('membership_requests')
        );
    }

    public function attachmentUrl(): Attribute
    {
        return Attribute::get(fn() => $this->attachment->getUrl());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function authorizedBy()
    {
        return $this->belongsTo(User::class, 'authorized_by_id');
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function invoices(): Attribute
    {
        $membershipItemName = Membership::BILL_INVOICE_ITEM_NAME;
        return Attribute::get(
            fn() => Invoice::where("items->{$membershipItemName}->ref", $this->id)
                ->get()
        );
    }

    public function isAccepted(): Attribute
    {
        return Attribute::get(fn() => $this->status === MembershipRequestStatus::APPROVED);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('membership_requests')
            ->singleFile();
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // All head programs and the program itself
        return collect([
            $this->membership->educationProgram->email => $this->membership->name,
            ...$this->membership->educationProgram->load([
                'heads:id,program_id,user_id' => [
                    'user:id,email',
                ],
            ])->heads
                ->pluck('user.email')
                ->mapWithKeys(fn($email) => [$email => $this->membership->name])
        ])->filter(fn($v, $k) => $k)->all();
    }
}
