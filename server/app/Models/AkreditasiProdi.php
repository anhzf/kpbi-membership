<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiProdi extends Model
{
  use HasFactory;

  const peringkatValues = ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'];

  /**
   * Get the KPBI Profile that owns the Kaprodi.
   */
  public function kpbiProfile()
  {
    return $this->belongsTo(KpbiProfile::class, 'profile_id');
  }
}
