<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FromLegacySeeder extends Seeder
{
    private DB $dbLegacy;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->dbLegacy = DB::connection('legacy');
    }

    private function importUserData()
    {
        $users = $this->dbLegacy->table('users')->find(1);
        return $users->map([$this, 'legacyUserConverter']);
    }

    private function importMemberData()
    {
        $members = $this->dbLegacy->table('kpbi_member')->get();
    }

    private function legacyUserConverter($user)
    {
        return new User($user);
    }
}
