<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property \App\Models\Enums\CollegeType|null $type
 * @property string|null $city
 * @property string|null $province
 * @property string|null $street_address
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Computed
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Media|null $img
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection<int, Accreditation> $accreditations
 * @property \Illuminate\Database\Eloquent\Collection<int, EducationProgram> $educationPrograms
 */
class College extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function img(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMedia('logo'));
    }

    public function imgUrl(): Attribute
    {
        return Attribute::get(fn () => $this->img?->getUrl());
    }

    public function accreditations()
    {
        return $this->morphMany(Accreditation::class, 'accreditable');
    }

    public function educationPrograms()
    {
        return $this->hasMany(EducationProgram::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }
}
