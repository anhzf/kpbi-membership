<?php

namespace App\Models;

use App\Models\Enums\EducationProgramHeadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationProgramHead extends Model
{
    use HasFactory;

    const DEFAULT_STATUS = EducationProgramHeadStatus::INACTIVE;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(EducationProgram::class);
    }
}
