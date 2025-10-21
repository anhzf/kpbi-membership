<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_name',
        'payload',
        'updated_by',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * Get the user who last updated this document
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
