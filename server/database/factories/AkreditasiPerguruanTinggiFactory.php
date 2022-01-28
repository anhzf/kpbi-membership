<?php

namespace Database\Factories;

use App\Models\AkreditasiPerguruanTinggi;
use Illuminate\Database\Eloquent\Factories\Factory;

class AkreditasiPerguruanTinggiFactory extends Factory
{
  /**
   * Define the model's default state.
   * Should attach the PerguruanTinggi with ->make() to make it work 👍
   *
   * @return array
   */
  public function definition()
  {
    return [
      'tipe' => 'BAN-PT',
      'peringkat' => $this->faker->randomElement(AkreditasiPerguruanTinggi::peringkatValues),
    ];
  }
}
