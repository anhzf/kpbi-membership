<?php

namespace App\Models;

use App\Concerns\HasExtra;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $education_program_id
 * @property int|null $registration_id a custom id provided by the admin
 * @property \Illuminate\Support\Carbon $period_end
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Accessors
 * @property-read string $name
 * @property-read string $email
 * @property-read bool $is_active
 * @property-read {lastReminderSent: string} $extra
 * Relationships
 * @property EducationProgram $educationProgram
 * @property \Illuminate\Database\Eloquent\Collection<MembershipRequest> $requests
 * @property \Illuminate\Database\Eloquent\Collection<Invoice> $invoices
 */
class Membership extends Model
{
    use HasFactory, HasExtra, Notifiable;

    const BILL_INVOICE_ITEM_NAME = 'membership';

    const BILL_INVOICE_ITEMS = [
        self::BILL_INVOICE_ITEM_NAME => [
            'price' => 500_000,
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
        return $this->morphMany(Invoice::class, 'receipt_to')
            // Provide default order
            ->orderBy('created_at');
    }

    public function name(): Attribute
    {
        return Attribute::get(fn() => join(' ', array_filter([
            $this->educationProgram->fullname,
        ])));
    }

    public function email() : Attribute
    {
        return Attribute::get(fn () => $this->educationProgram->email);
    }

    public function request()
    {
        return $this->requests();
    }

    public function isActive(): Attribute
    {
        return Attribute::get(fn() => $this->period_end?->isFuture() ?? false);
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
        $this->educationProgram->heads->each(function (EducationProgramHead $head) {
            $head->user
                ->append('img')
                ->makeHidden('media');
        });

        return $this;
    }

    private function createBill($isNew = false)
    {
        $items = [
            ...self::BILL_INVOICE_ITEMS,
            self::BILL_INVOICE_ITEM_NAME => [
                ...self::BILL_INVOICE_ITEMS[self::BILL_INVOICE_ITEM_NAME],
                'price' => Setting::find('membership_fee')->value->number_value
            ]
        ];

        return $this->invoices()->create([
            'receipt_to_details' => [
                'name' => $this->educationProgram->fullname,
                'membership_id' => $this->id,
                'addresses' => $this->educationProgram->college->addresses,
            ],
            'items' => $items,
            'due_at' => $isNew
                // @BUSINESS
                ? Carbon::create($this->created_at)->addWeeks(2)
                : now()->addYear(),
        ]);
    }

    /**
     * Return active bills, create a bill if meet the condition
     *
     * @return \App\Models\Invoice[]
     */
    public function bill()
    {
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Invoice> */
        $activeBills = $this->invoices()
            ->where('paid_at', null)
            ->get();

        if (
            $activeBills->isEmpty()
            && ($isDue = $this->period_end?->isPast() ?? true)
        ) {
            $isFirstTime = $this->invoices()->first() === null;
            $activeBills->push($this->createBill($isFirstTime));
        }

        return $activeBills;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function active($active = true)
    {
        return self::where('period_end', $active ? '>' : '<', now());
    }
}
