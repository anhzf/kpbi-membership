<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

/**
 * @property int $id
 * @property string $name
 * @property int $college_id
 * @property \App\Enums\AcademicDegree $degree
 * @property string $department
 * @property string $faculty
 * @property string $email
 * @property string $phone_number
 * @property string $external_link
 * Computed
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Media|null $img
 * Relationships
 * @property College $college
 * @property \Illuminate\Database\Eloquent\Collection<Accreditation> $accreditations
 * @property \Illuminate\Database\Eloquent\Collection<EducationProgramHead> $heads
 * @property \Illuminate\Database\Eloquent\Collection<Course> $courses
 * @property Membership|null $membership
 */
class EducationProgram extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function img(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('logo'),
            set: fn (FileAdder $v) => $v->toMediaCollection('logo')
        );
    }

    public function accreditations()
    {
        return $this->morphMany(Accreditation::class, 'accreditable');
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'education_program_id');
    }

    public function heads()
    {
        return $this->hasMany(EducationProgramHead::class, 'program_id');
    }

    public function membership()
    {
        return $this->hasOne(Membership::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }
}
