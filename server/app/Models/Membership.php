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
 * @property \Illuminate\Database\Eloquent\Collection<MembershipRequest> $requests
 */
class Membership extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'period_end' => 'datetime',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function educationProgram()
    {
        return $this->belongsTo(EducationProgram::class);
    }

    public function requests()
    {
        return $this->hasMany(MembershipRequest::class);
    }

    public function loadFullProfile()
    {
        $this->educationProgram
            ->append('img')
            ->makeHidden('media');
        $this->educationProgram->loadMissing([
            'college.accreditations',
            'heads.user',
            'accreditations'
        ]);
        $this->educationProgram->college
            ->append('img')
            ->makeHidden('media');

        return $this;
    }
}
