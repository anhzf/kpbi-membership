<?php

namespace App\Models;

use App\Models\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property ?string $phone_number
 * @property string $password hidden
 * @property UserRole $role
 * @property string $remember_token hidden
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Computed
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Media|null $img
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection<EducationProgramHead> $headProgramOf
 * @property \Illuminate\Database\Eloquent\Collection<Invoice> $invoices
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRole::class,
    ];

    public function img(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('avatar')?->getUrl(),
            set: fn (FileAdder $v) => $v->toMediaCollection('avatar')
        );
    }

    public function headProgramOf()
    {
        return $this->hasMany(EducationProgramHead::class);
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'receipt_to');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    /**
     * Current workaround is identify by the last of headProgram.
     * This behavior is to support multiple headProgram for user.
     */
    public function headOf()
    {
        return $this->headProgramOf->last();
    }
}
