<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $nama_singkat
 * @property string $nama_lengkap
 * @property string|null $status
 * @property string|null $kota
 * @property string|null $provinsi
 * @property string|null $alamat
 * relationship property
 * @property \App\Models\KpbiProfile $kpbiProfile
 * @property \App\Models\AkreditasiPerguruanTinggi[] $akreditasiPerguruanTinggi
 */
class PerguruanTinggi extends Model
{
  use HasFactory;

  const statusValues = ['NEGERI', 'SWASTA'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

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
  public function akreditasi()
  {
    return $this->hasMany(AkreditasiPerguruanTinggi::class);
  }

  /**
   * Get the active akreditasi that owns the relation.
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public static function getAkreditasiActive(HasMany $relation)
  {
    $q = $relation
      ->where('tanggal_aktif', '<=', now())
      ->where('tanggal_kadaluarsa', '>=', now())
      ->orWhere(fn ($q) => $q
        ->whereNull('tanggal_kadaluarsa')
        ->whereNull('tanggal_aktif'))
      ->orderBy('updated_at');

    return $q;
  }
}
