<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationProgram extends Model
{
    use HasFactory;

    public function accreditations()
    {
        return $this->morphMany(Accreditation::class, 'accreditable');
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function head()
    {
        return $this->hasMany(EducationProgramHead::class);
    }
}
