<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class KaprodiFactory extends Factory
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
      'nama' => $this->faker->name,
      'periode_mulai' => Date::now()->subYear(),
      'periode_purna' => Date::now()->addYear(),
      'email' => $this->faker->safeEmail,
      'notelp' => $this->faker->phoneNumber,
    ];
  }
}
