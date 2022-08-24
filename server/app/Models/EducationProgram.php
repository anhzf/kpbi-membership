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
 * @property Accreditation[] $accreditations
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

    public function img()
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

    public function heads()
    {
        return $this->hasMany(EducationProgramHead::class, 'program_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }
}
