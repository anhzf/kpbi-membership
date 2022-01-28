<?php

namespace Database\Factories;

use App\Models\PerguruanTinggi;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerguruanTinggiFactory extends Factory
{
  /**
   * Define the model's default state.
   * Should attach the KpbiProfile with ->make() to make it work 👍
   *
   * @return array
   */
  public function definition()
  {
    return [
      'nama_singkat' => $this->faker->word,
      'nama_lengkap' => $this->faker->company,
      'status' => $this->faker->randomElement(PerguruanTinggi::statusValues),
      'kota' => $this->faker->city,
      'provinsi' => $this->faker->state,
      'alamat' => $this->faker->address,
     ];
  }
}
