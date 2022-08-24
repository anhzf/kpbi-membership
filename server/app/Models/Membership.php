<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $education_program_id
 * @property \Illuminate\Support\Carbon $period_end
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Relationships
 * @property EducationProgram $educationProgram
 */
class Membership extends Model
{
    use HasFactory;

    public function educationProgram()
    {
        return $this->belongsTo(EducationProgram::class);
    }

    public function profile()
    {
        $program = $this->educationProgram->load(['college']);

        return (object) [
            ...$this->toArray(),
            'education_program' => $program,
        ];
    }
}
