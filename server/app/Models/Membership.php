<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Relationships
 * @property EducationProgram $educationProgram
 */
class Membership extends Model
{
    use HasFactory;

    public function educationProgram()
    {
        $this->belongsTo(EducationProgram::class);
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
