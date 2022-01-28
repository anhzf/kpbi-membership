<?php

namespace Database\Seeders;

use App\Models\AkreditasiPerguruanTinggi;
use App\Models\AkreditasiProdi;
use App\Models\Kaprodi;
use App\Models\KpbiProfile;
use App\Models\PerguruanTinggi;
use App\Models\User;
use Illuminate\Database\Seeder;

class KpbiProfileSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    KpbiProfile::factory()
      ->has(PerguruanTinggi::factory()->has(AkreditasiPerguruanTinggi::factory()))
      ->has(Kaprodi::factory())
      ->has(AkreditasiProdi::factory())
      ->for(User::factory())
      ->create();
  }
}
