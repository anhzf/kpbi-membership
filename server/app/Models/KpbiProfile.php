<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $jenjang
 * @property string $nama_prodi
 * @property string|null $nama_jurusan
 * @property string $nama_fakultas
 * @property string|null $nama_jurusan
 * @property string $nama_perguruan_tinggi
 * @property string|null $link
 * @property string $email_kantor_prodi
 * @property string|null $notelp_kantor_prodi
 * computed property
 * @property string $username
 * aggregation property
 * @property string $nama_perguruan_tinggi
 * relationship property
 * @property \App\Models\User $user
 * @property \App\Models\PerguruanTinggi $perguruanTinggi
 * @property \App\Models\AkreditasiPerguruanTinggi $akreditasiPerguruanTinggi
 * @property \App\Models\AkreditasiProdi $akreditasiProdi
 * @property \App\Models\Kaprodi $kaprodi
 */
class KpbiProfile extends Model
{
  use HasFactory;

  const jenjangValues = ['S1', 'S2', 'S3'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  public function getUsernameAttribute()
  {
    return KpbiProfile::constructUsername($this, $this->perguruanTinggi);
  }

  /**
   * Get the user that owns the profile.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Get the perguruan tinggi that owns the profile.
   */
  public function perguruanTinggi()
  {
    return $this->hasOne(PerguruanTinggi::class, 'profile_id');
  }

  /**
   * Get the kaprodi that owns the profile.
   */
  public function kaprodi()
  {
    return $this->hasMany(Kaprodi::class, 'profile_id');
  }

  /**
   * Get the active kaprodi that owns the $relation.
   * @return Illuminate\Database\Eloquent\Relations\HasMany
   */
  public static function getKaprodiActive(HasMany $relation)
  {
    $q = $relation
      ->where('periode_mulai', '<=', now())
      ->where('periode_purna', '>=', now());

    return $q;
  }

  /**
   * Get the akreditasi prodi that owns the profile.
   */
  public function akreditasiProdi()
  {
    return $this->hasMany(AkreditasiProdi::class, 'profile_id');
  }

  /**
   * Get the active akreditasi prodi that owns the $relation.
   * @return Illuminate\Database\Eloquent\Relations\HasMany
   */
  public static function getAkreditasiProdiActive(HasMany $relation)
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

  /**
   * @return \Illuminate\Database\Eloquent\Model|object|static|null
   */
  public function details(bool $validOnly = true)
  {
    $q = $validOnly
      ? $this->with([
        'perguruanTinggi.akreditasi' => fn ($q) => PerguruanTinggi::getAkreditasiActive($q),
        'akreditasiProdi' => fn ($q) => KpbiProfile::getAkreditasiProdiActive($q),
        'kaprodi' => fn ($q) => KpbiProfile::getKaprodiActive($q),
      ])
      : $this->with(
        'perguruanTinggi.akreditasi',
        'akreditasiProdi',
        'kaprodi',
      );

    return $q->first();
  }



  public static function constructUsername(KpbiProfile $profile, PerguruanTinggi $perguruanTinggi)
  {
    $firstName = $profile->jenjang;
    $middleName = 'BIO';
    $lastName = $perguruanTinggi->nama_singkat;

    return strtoupper($firstName . ' ' . $middleName . ' ' . $lastName);
  }
}
