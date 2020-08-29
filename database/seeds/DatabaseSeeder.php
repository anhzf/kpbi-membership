<?php

use App\KPBI;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // DB::table('users')->insert([
        //     'name' => 'anhzf',
        //     'email' => 'alwan.nuha7@gmail.com',
        //     'password' => Hash::make('lorem ipsum'),
        //     'email_verified_at' => now(),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        factory(User::class, 50)->create()
            ->each(function ($user) {
                // [$jenjang, $ptSingkat] = explode(' PBIO ', $user->name);
                $user->kpbi_profile()->save(
                    factory(KPBI::class)->make(/* [
                        'jenjang' => $jenjang,
                        'pt' => json_encode([
                            'lengkap' => Faker::create()->words(3),
                            'singkat' => $ptSingkat
                        ])
                    ] */)
                );
            });
    }
}
