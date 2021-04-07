<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\KPBI;
use App\User;
use Faker\Generator as Faker;

$factory->define(KPBI::class, function (Faker $faker) {
  $jenjangValues = ['S1', 'S2', 'S3'];
  $statusValues = ['Negeri', 'Swasta'];
  $akreditasiValues = ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'];

  return [
    'jenjang' => $faker->randomElement($jenjangValues),
    'nama_prodi' => $faker->word,
    'jurusan' => $faker->words(3, true),
    'fakultas' => $faker->words(3, true),
    'pt' => [
      'lengkap' => $faker->words(3, true),
      'singkat' => $faker->word,
    ],
    'status' => $faker->randomElement($statusValues),
    'akreditasi_prodi' => [
      'akreditasi' => $faker->randomElement($akreditasiValues),
      'tanggal' => $faker->dateTime,
      'internasional' => $faker->randomElement($akreditasiValues),
    ],
    'akreditasi_pt' => $faker->randomElement($akreditasiValues),
    'web_prodi' => $faker->url,
    'alamat_kampus' => [
      'alamat' => $faker->streetAddress,
      'kota' => $faker->city,
      'provinsi' => $faker->state,
    ],
    'kaprodi' => [
      'nama' => $faker->name('male'),
      'periode' => [
        'mulai' => $faker->year,
        'purna' => $faker->year
      ],
      'email' => $faker->safeEmail,
      'no' => $faker->phoneNumber,
    ],
    'email_prodi' => $faker->safeEmail,
    'no_telp_prodi' => $faker->phoneNumber,
  ];
});
