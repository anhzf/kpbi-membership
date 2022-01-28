<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiPerguruanTinggi extends Model
{
  use HasFactory;

  const peringkatValues = ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'];

  /**
   * Get the PerguruanTinggi that owns the Akreditasi.
   */
  public function perguruanTinggi()
  {
    return $this->belongsTo(PerguruanTinggi::class);
  }
}
