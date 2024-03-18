<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $education_program_id
 * @property string $name
 * @property string $code
 * @property int $credits
 * @property string $description
 * @property string $lecturer
 * @property object $info
 * @property \App\Models\Enums\SemesterType $semester
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Relationships
 * @property EducationProgram $educationProgram
 */
class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'semester' => \App\Models\Enums\SemesterType::class,
        'info' => AsArrayObject::class,
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'info' => '{}',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'education_program_id'];

    public function educationProgram()
    {
        return $this->belongsTo(EducationProgram::class);
    }
}
