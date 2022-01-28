<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaprodi extends Model
{
  use HasFactory;

  /**
   * Get the KPBI Profile that owns the Kaprodi.
   */
  public function kpbiProfile()
  {
    return $this->belongsTo(KpbiProfile::class, 'profile_id');
  }
}
