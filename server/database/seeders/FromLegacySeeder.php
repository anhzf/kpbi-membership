<?php

namespace Database\Seeders;

use App\Enums\AcademicDegree;
use App\Models\Accreditation;
use App\Models\College;
use App\Models\EducationProgram;
use App\Models\EducationProgramHead;
use App\Models\Enums\CollegeType;
use App\Models\Enums\EducationProgramHeadStatus;
use App\Models\Membership;
use App\Models\User;
use Error;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FromLegacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oldDB = DB::connection('legacy_mysql');
        $oldAppUrl = 'https://anggota.kpbi.or.id/';
        $members = $oldDB->table('kpbi_member')->get();
        $users = $oldDB->table('users')->get();

        DB::transaction(function () use ($members, $users, $oldDB, $oldAppUrl) {
            $members->each(function (object $member) use ($users, $oldDB, $oldAppUrl) {
                $srcCollege = json_decode($member->pt);

                // Adapt the college type from the legacy database to the new one
                $college = new College();
                $srcCollegeAddress = json_decode($member->alamat_kampus);

                $college->name = $srcCollege->lengkap;
                $college->short_name = $srcCollege->singkat;
                $college->type = $member->status === 'Negeri'
                    ? CollegeType::STATE : CollegeType::PRIVATE;
                $college->city = $srcCollegeAddress->kota;
                $college->province = $srcCollegeAddress->provinsi;
                $college->street_address = $srcCollegeAddress->alamat;

                $college->save();

                // Insert college accreditation data from the legacy database if any
                if ($member->akreditasi_pt !== null) {
                    $collegeAccreditation = new Accreditation();
                    $collegeAccreditation->label = '';
                    $collegeAccreditation->value = $member->akreditasi_pt;
                    $collegeAccreditation->accreditable()->associate($college);

                    $collegeAccreditation->save();
                }

                // Adapt the EducationProgram data from the legacy database to the new one
                $program = new EducationProgram();
                $program->name = $member->nama_prodi;
                $program->college()->associate($college);
                $program->degree = self::academicDegreeFromLegacy($member->jenjang);
                $program->department = $member->jurusan;
                $program->faculty = $member->fakultas;
                $program->email = $member->email_prodi;
                $program->phone_number = $member->no_telp_prodi;
                $program->external_link = $member->web_prodi;

                $program->save();

                // Insert program accreditation data from the legacy database if any
                $srcProgramAccreditation = json_decode($member->akreditasi_prodi);

                if ($srcProgramAccreditation->akreditasi !== null) {
                    $programAccreditation = new Accreditation();
                    $programAccreditation->accreditable()->associate($program);
                    $programAccreditation->label = 'BAN-PT';
                    $programAccreditation->value = $srcProgramAccreditation->akreditasi;
                    $programAccreditation->created_at = new Carbon($srcProgramAccreditation->tanggal);
                    $programAccreditation->updated_at = new Carbon($srcProgramAccreditation->tanggal);

                    $programAccreditation->save();
                }

                // Insert internasional program accreditation data from the legacy database if any
                if ($srcProgramAccreditation->internasional !== null) {
                    $programAccreditation = new Accreditation();
                    $programAccreditation->accreditable()->associate($program);
                    $programAccreditation->label = 'Internasional';
                    $programAccreditation->value = $srcProgramAccreditation->internasional;

                    $programAccreditation->save();
                }

                // Create user as the manager of membership of the program
                $srcKaprodi = json_decode($member->kaprodi);
                $srcUser = $users->filter(fn (object $el) => $el->id === $member->user_id)->first();

                /** @var User */
                $user = User::where('email', $srcUser->email)->first() ?? new User();

                if (!$user->exists) {
                    $user = new User();
                    $user->name = $srcKaprodi->nama ?? 'No Name';
                    $user->email = $srcUser->email;
                    $user->phone_number = $srcKaprodi->no ?? null;
                    $user->password = Hash::make(Str::orderedUuid());
                    $user->email_verified_at = $srcUser->email_verified_at ?? null;
                    $user->created_at = $srcUser->created_at;
                    $user->updated_at = $srcUser->updated_at;

                    $user->save();
                }

                // Set user as the head of the program
                $programHead = new EducationProgramHead();
                $programHead->user()->associate($user);
                $programHead->program()->associate($program);
                $programHead->status = EducationProgramHeadStatus::ACTIVE;
                $programHead->period_start = isset($srcKaprodi->periode) ?
                    self::tryParsePeriod($srcKaprodi->periode->mulai) : null;
                $programHead->period_end = isset($srcKaprodi->periode) ?
                    self::tryParsePeriod($srcKaprodi->periode->purna) : null;
                $programHead->created_at = $srcUser->created_at;
                $programHead->updated_at = $srcUser->updated_at;

                $programHead->save();

                // Create membership of the program
                $membership = new Membership();
                $membership->educationProgram()->associate($program);
                $membership->period_end = new Carbon("last day of December 2022");

                $membership->save();
            });
        });
    }

    private static function academicDegreeFromLegacy(string $val)
    {
        $entries = [
            'S1' => AcademicDegree::BACHELOR,
            'S2' => AcademicDegree::MASTER,
            'S3' => AcademicDegree::DOCTOR,
        ];

        return $entries[$val] ?? throw new Error('Unknown academic degree');
    }

    private static function tryParsePeriod($input)
    {
        try {
            return new Carbon("first day of January {$input}");
        } catch (\Throwable $th) {
            return null;
        }
    }
}
