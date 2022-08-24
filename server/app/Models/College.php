<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    public function accreditations()
    {
        return $this->morphMany(Accreditation::class, 'accreditable');
    }

    public function educationPrograms()
    {
        return $this->hasMany(EducationProgram::class);
    }
}
