<?php

namespace Database\Factories;

use App\Models\KpbiProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class KpbiProfileFactory extends Factory
{
  /**
   * Define the model's default state.
   * Should attach the User with ->make() to make it work 👍
   *
   * @return array
   */
  public function definition()
  {
    return [
      'jenjang' => $this->faker->randomElement(KpbiProfile::jenjangValues),
      'nama_prodi' => 'Pendidikan Biologi',
      'nama_jurusan' => null,
      'nama_fakultas' => 'Fakultas Keguruan dan Ilmu Pendidikan',
      'nama_perguruan_tinggi' => $this->faker->company,
      'link' => $this->faker->url,
      'email_kantor_prodi' => $this->faker->safeEmail,
      'notelp_kantor_prodi' => $this->faker->phoneNumber,
    ];
  }
}
