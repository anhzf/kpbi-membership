<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $nama
 * @property date|null $periode_mulai
 * @property date|null $periode_purna
 * @property string $email
 * @property string|null $notelp
 * relationship
 * @property \App\Models\KpbiProfile $kpbiProfile
 */
class Kaprodi extends Model
{
  use HasFactory;

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * Get the KPBI Profile that owns the Kaprodi.
   */
  public function kpbiProfile()
  {
    return $this->belongsTo(KpbiProfile::class, 'profile_id');
  }
}
