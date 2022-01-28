<?php

namespace Database\Factories;

use App\Models\AkreditasiProdi;
use Illuminate\Database\Eloquent\Factories\Factory;

class AkreditasiProdiFactory extends Factory
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
      'tipe' => 'BAN-PT',
      'peringkat' => $this->faker->randomElement(AkreditasiProdi::peringkatValues),
    ];
  }
}
