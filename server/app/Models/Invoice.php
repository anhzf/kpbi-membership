<?php

namespace App\Models;

use App\Utils;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property object $receipt_to_details
 * @property Collection<string, object> $items
 * @property \Illuminate\Support\Carbon $due_at
 * @property ?\Illuminate\Support\Carbon $paid_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * Getter
 * @property-read int $total
 * Relationships
 * @property User|Membership $receipt_to
 */
class Invoice extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($invoice) {
            $invoice->syncDocument();
        });

        static::updated(function ($invoice) {
            if ($invoice->document) {
                $invoice->syncDocument();
            }
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'receipt_to_details' => AsArrayObject::class,
        'items' => AsCollection::class,
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'receipt_to_details' => '{}',
        'items' => '{}',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [/* 'receiptTo' */];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [/* 'receipt_to_id', 'receipt_to_type' */];

    protected $appends = ['total', 'is_active'];

    public function receiptTo()
    {
        return $this->morphTo();
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Sync document payload with current invoice data
     */
    public function syncDocument()
    {
        if (!$this->document) {
            // Create document if it doesn't exist
            $document = $this->document()->create([
                'template_name' => 'invoice',
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
        // Get the invoice data exactly like the current showDocumentPayload method
        $invoice_number = join('/', [
            Str::of($this->id)->padLeft(4, '0'),
            \App\Utils::intToRomanNumeral($this->created_at->month),
            'KPBI',
            $this->created_at->year,
        ]);

        $receipt_to = $this->receipt_to_details;
        $_item = (object) $this->items[\App\Models\Membership::BILL_INVOICE_ITEM_NAME];
        $item = [
            'name' => \App\Models\Membership::BILL_INVOICE_ITEM_NAME,
            'price' => $_item->price,
            'qty' => $_item->qty,
            'desc' => $_item->desc,
        ];

        // Pre-compute all the values that templates currently calculate
        $total_amount = $item['price'] * $item['qty'];

        return [
            'invoice_number' => $invoice_number,
            'receipt_to' => $receipt_to,
            'item' => $item,
            'due_at' => $this->due_at,
            'paid_at' => $this->paid_at,
            'created_at' => $this->created_at,
            'contact_person' => \App\Models\User::find(\App\Models\Setting::find('doc_invoice_contact_person_user')->value, ['name', 'email', 'phone_number', 'employee_id']),
            'treasurer' => \App\Models\User::find(\App\Models\Setting::find('doc_invoice_treasurer_user')->value, ['name', 'email', 'phone_number', 'employee_id']),

            // Pre-computed values for template
            'formatted_dates' => [
                'invoice_date' => $this->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY'),
                'due_date' => $this->due_at->locale('id')->isoFormat('dddd, D MMMM YYYY'),
                'created_year' => $this->created_at->year,
                'due_date_formatted' => $this->due_at->locale('id')->isoFormat('dddd, D MMMM YYYY'),
            ],
            'formatted_amounts' => [
                'price_per_unit' => $this->formatCurrency($item['price']),
                'total_amount' => $this->formatCurrency($total_amount),
                'total_in_words' => Utils::toIndonesianWords($total_amount),
            ],
            'time_units' => [
                'years_text' => $this->toDateTimeUnit($item['qty'] * 365 * 24 * 3600_000),
            ],
            // Invoice link and QR will be generated client-side since they depend on current URL
        ];
    }

    /**
     * Format currency to Indonesian Rupiah
     */
    private function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.') . ',-';
    }

    /**
     * Convert number to Indonesian words
     */
    private function toIndonesianWords($number)
    {
        $units = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
        $teens = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
        $tens = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
        $thousands = ['', 'ribu', 'juta', 'miliar', 'triliun'];

        $convertHundreds = function ($num) use ($units, $teens, $tens) {
            $words = '';
            if ($num > 99) {
                if ($num == 100) {
                    $words .= 'seratus ';
                } else {
                    $words .= $units[floor($num / 100)] . ' ratus ';
                }
                $num %= 100;
            }
            if ($num > 19) {
                $words .= $tens[floor($num / 10)] . ' ';
                $num %= 10;
            }
            if ($num > 0 && $num < 10) {
                $words .= $units[$num] . ' ';
            } elseif ($num >= 10 && $num < 20) {
                $words .= $teens[$num - 10] . ' ';
            }
            return trim($words);
        };

        if ($number == 0) return 'nol';

        $word = '';
        $level = 0;

        while ($number > 0) {
            $remainder = $number % 1000;
            if ($remainder > 0) {
                if ($remainder == 1 && $level == 1) {
                    $word = "seribu $word";
                } else {
                    $word = $convertHundreds($remainder) . ' ' . $thousands[$level] . ' ' . $word;
                }
            }
            $number = floor($number / 1000);
            $level++;
        }

        return trim($word);
    }

    /**
     * Convert milliseconds to time unit text
     */
    private function toDateTimeUnit($milliseconds)
    {
        $years = floor($milliseconds / (365 * 24 * 3600_000));
        return $years . ' tahun';
    }

    public function total(): Attribute
    {
        return Attribute::get(fn() => $this->items->sum(function ($item) {
            return $item['price'] * $item['qty'];
        }));
    }

    public function isActive(): Attribute
    {
        return Attribute::get(fn() => $this->paid_at === null
            && $this->due_at->isFuture());
    }
}
