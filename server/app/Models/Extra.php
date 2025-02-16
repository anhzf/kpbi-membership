<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property Model $model
 * @property \stdClass $data
 */
class Extra extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => 'object',
    ];

    protected $attributes = [
        'data' => '{}',
    ];

    protected $guarded = [];

    protected $hidden = ['model_id', 'model_type', 'id', 'created_at', 'updated_at'];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
