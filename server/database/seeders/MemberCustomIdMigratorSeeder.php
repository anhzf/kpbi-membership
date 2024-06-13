<?php

namespace Database\Seeders;

use App\Models\EducationProgram;
use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MemberCustomIdMigratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = array_map(fn ($row) => str_getcsv($row, ';'), file(Storage::path('Data Sertifikat KPBI.csv')));
        array_walk($rows, function (&$a) use ($rows) {
            $a = array_combine($rows[0], $a);
        });
        array_shift($rows);

        $month_names = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];

        $sorted = collect($rows)->sortByDesc(function ($row) use ($month_names) {
            [$dd, $MM, $yyyy] = explode(' ', $row['Tanggal bayar/transfer']) + [0, 0, 0];

            $mm = array_search(strtolower($MM), $month_names);

            return Carbon::create((int) $yyyy, $mm === false ? 0 : $mm + 1, (int) $dd)->timestamp;
        })->values();

        $cleaned = [];

        foreach ($sorted as $item) {
            $key = $item['Jenjang'] . ' ' . $item['Singkatan PT'];
            $cleaned[$key] = $item;
        }

        DB::beginTransaction();

        $members = Membership::with('educationProgram.college')->get();

        $registeredIds = array_keys($cleaned);

        foreach ($members as $member) {
            $key = join(' ', [
                EducationProgram::DEGREE_DISPLAY_NAME[$member->educationProgram->degree->name],
                $member->educationProgram->college->short_name,
            ]);

            if (in_array($key, $registeredIds)) {
                $id = $cleaned[$key]['No keanggotaan'];

                [$no, $mmCreated,, $yyyyCreated] = explode('/', $id);

                [$ddCreated] = explode(' ', $cleaned[$key]['Tanggal bayar/transfer']);

                $member->registration_id = (string) ((int) $no);
                $member->created_at = Carbon::create($yyyyCreated, $mmCreated, $ddCreated ? $ddCreated : 1);

                $member->save();
            }
        }

        DB::commit();
    }
}
