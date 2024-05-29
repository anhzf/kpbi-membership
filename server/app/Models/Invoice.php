<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property object $receipt_to_details
 * @property Collection $items
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
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function receiptTo()
    {
        return $this->morphTo();
    }

    public function total(): Attribute
    {
        return Attribute::get(fn () => $this->items->sum(function ($item) {
            return $item['price'] * $item['qty'];
        }));
    }
}
