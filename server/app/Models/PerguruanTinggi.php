<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerguruanTinggi extends Model
{
  use HasFactory;

  const statusValues = ['NEGERI', 'SWASTA'];

  /**
   * Get the KPBI Profile that owns the perguruan tinggi.
   */
  public function kpbiProfile()
  {
    return $this->belongsTo(KpbiProfile::class);
  }

  /**
   * Get the akreditasi perguruan tinggi that owns the perguruan tinggi.
   */
  public function akreditasiPerguruanTinggi()
  {
    return $this->hasMany(AkreditasiPerguruanTinggi::class);
  }
}
