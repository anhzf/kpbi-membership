<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $label
 * @property string $value
 * @property string $accreditable_type
 * @property int $accreditable_id
 * @property \Illuminate\Support\Carbon|null $valid_from
 * @property \Illuminate\Support\Carbon|null $valid_until
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Relationships
 * @property College|EducationProgram $accreditable
 */
class Accreditation extends Model
{
    use HasFactory;

    const VALUES = ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['label', 'value', 'valid_from', 'valid_until'];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    public function accreditable()
    {
        return $this->morphTo();
    }
}
