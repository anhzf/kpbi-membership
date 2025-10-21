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

    protected static function booted()
    {
        static::created(function ($membership) {
            $membership->syncDocument();
        });

        static::updated(function ($membership) {
            if ($membership->document) {
                $membership->syncDocument();
            }
        });
    }

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

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Sync document payload with current membership data
     */
    public function syncDocument()
    {
        if (!$this->document) {
            // Create document if it doesn't exist
            $document = $this->document()->create([
                'template_name' => 'membership-certificate',
                'payload' => $this->getDocumentPayload(),
                'updated_by' => auth()->id(),
            ]);

            $this->update(['document_id' => $document->id]);
            $this->load('document');
        } else {
            // Update existing document
            $this->document->update([
                'payload' => $this->getDocumentPayload(),
                'updated_by' => auth()->id(),
            ]);
        }
    }

    /**
     * Get document payload data
     */
    protected function getDocumentPayload()
    {
        // Load necessary relationships
        $this->load(['educationProgram.college']);

        // Get approved request for validity dates
        $request = $this->requests()->where('status', 'approved')->latest()->first();

        // Generate certificate number like in the current template
        $number = [
            ($this->registration_id ?: $this->id),
            str_pad((string)($this->created_at->month), 2, '0', STR_PAD_LEFT),
            'KPBI',
            $this->created_at->year,
        ];
        $certificate_number = implode('/', $number);

        // Generate formatted fullname like in template
        $degree_labels = [
            'bachelor' => 'S1',
            'master' => 'S2',
            'doctor' => 'S3',
        ];
        $degree_value = $this->educationProgram->degree?->value ?? '';
        $degree_label = $degree_labels[$degree_value] ?? '';
        $fullname_parts = [
            trim($degree_label . ' ' . $this->educationProgram->name),
            $this->educationProgram->faculty,
            $this->educationProgram->college->name ?? null,
        ];
        $formatted_fullname = implode(', ', array_filter($fullname_parts));

        // Generate QR text like in template
        $validity_start = $this->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $validity_end = $request?->valid_until?->locale('id')->isoFormat('dddd, D MMMM YYYY') ?? 'N/A';
        $qr_text = "Prodi {$formatted_fullname} keanggotaan berlaku mulai {$validity_start} s.d. {$validity_end} dengan nomor keanggotaan {$certificate_number}";

        return [
            'membership_id' => $this->id,
            'certificate_number' => $certificate_number,
            'member_name' => $this->name,
            'education_program' => [
                'name' => $this->educationProgram->name,
                'faculty' => $this->educationProgram->faculty,
                'degree' => $this->educationProgram->degree,
                'formatted_fullname' => $formatted_fullname,
            ],
            'college' => [
                'name' => $this->educationProgram->college->name ?? null,
            ],
            'validity' => [
                'start' => $this->created_at,
                'end' => $request?->valid_until,
                'start_formatted' => $validity_start,
                'end_formatted' => $validity_end,
            ],
            'qr_text' => $qr_text,
            'registration_id' => $this->registration_id,
            'created_at' => $this->created_at,
            'period_end' => $this->period_end,
        ];
    }

    public function name(): Attribute
    {
        return Attribute::get(fn() => join(' ', array_filter([
            $this->educationProgram->fullname,
        ])));
    }

    public function email(): Attribute
    {
        return Attribute::get(fn() => $this->educationProgram->email);
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
     * Return active bills, create a bill if met the condition
     *
     * @return \App\Models\Invoice[]
     */
    public function bill()
    {
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Invoice> */
        $activeBills = $this->invoices()
            ->where('paid_at', null)
            ->get();

        // Create a new bill every year when period ends and no bill created this year yet
        if ($isDue = $this->period_end?->isPast() ?? true) {
            $lastActiveBill = $activeBills->sortByDesc('created_at')->first();
            $shouldCreateNewBill = !$lastActiveBill ||
                $lastActiveBill->created_at->year < now()->year;

            if ($shouldCreateNewBill) {
                $isFirstTime = $this->invoices()->first() === null;
                $activeBills->push($this->createBill($isFirstTime));
            }
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
