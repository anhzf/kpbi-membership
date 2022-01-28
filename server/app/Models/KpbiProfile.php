<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpbiProfile extends Model
{
  use HasFactory;

  const jenjangValues = ['S1', 'S2', 'S3'];

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
   * Get the akreditasi prodi that owns the profile.
   */
  public function akreditasiProdi()
  {
    return $this->hasMany(AkreditasiProdi::class, 'profile_id');
  }
}
