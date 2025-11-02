<?php

namespace App\Models;

use App\Models\Enums\EducationProgramHeadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $program_id
 * @property \App\Models\Enums\EducationProgramHeadStatus $status
 * @property \Illuminate\Support\Carbon $period_start
 * @property \Illuminate\Support\Carbon $period_end
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Relationships
 * @property User $user
 * @property EducationProgram $program
 */
class EducationProgramHead extends Model
{
    use HasFactory;

    const DEFAULT_STATUS = EducationProgramHeadStatus::INACTIVE;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected static function booted()
    {
        static::updated(function (EducationProgramHead $head) {
            if ($head->program && $head->program->membership && $head->program->membership->document) {
                $head->program->membership->syncDocument();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(EducationProgram::class, 'program_id');
    }
}
