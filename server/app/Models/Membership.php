<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $education_program_id
 * @property int|null $registration_id a custom id provided by the admin
 * @property \Illuminate\Support\Carbon $period_end
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Relationships
 * @property EducationProgram $educationProgram
 * @property \Illuminate\Database\Eloquent\Collection<MembershipRequest> $requests
 * @property \Illuminate\Database\Eloquent\Collection<Invoice> $invoices
 */
class Membership extends Model
{
    use HasFactory;

    const BILL_INVOICE_ITEMS = [
        'membership' => [
            'price' => 300_000,
            'qty' => 1,
            'desc' => 'Membership fee'
        ],
    ];

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

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'receipt_to');
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
            ->append('img_url')
            ->makeHidden('media');

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<Invoice>
     */
    public function getActiveBills()
    {
        return $this->invoices()->where('paid_at', null)->get();
    }

    public function createBill()
    {
        return new Invoice([
            'receipt_to_details' => [
                'name' => $this->educationProgram->name,
                'membership_id' => $this->id,
                'addresses' => $this->educationProgram->college->addresses,
            ],
            'items' => self::BILL_INVOICE_ITEMS,
            'due_at' => now()->addYear(),
        ]);
    }
}
